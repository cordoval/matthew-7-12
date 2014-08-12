from fabric.api import *
from fabric.contrib.files import exists
import os
from time import strftime
import yaml
import getpass

repo = 'git@github.com:cordoval/matthew-7-12.git'
env.install_path = '/var/www/vhosts/matthew.gushphp.org'
# Local defaults
env.run = local
env.hosts = ['localhost']
env.run_user = getpass.getuser()
env.install_params = 'local'

# Alias for local()
def localhost(path=env.install_path):
    local(path)

def local(path=env.install_path):
    env.run = local
    env.hosts = ['localhost']
    env.install_path = os.path.abspath(os.path.expanduser(path))
    env.run_user = getpass.getuser()
    env.install_params = 'local'

def prod():
    env.run = run
    env.hosts = ['gushphp']
    env.run_user = 'www-data'
    env.use_ssh_config = True
    env.install_params = 'prod'

def staging():
    env.run = run
    env.hosts = ['gushphp']
    env.run_user = 'www-data'
    env.use_ssh_config = True
    env.install_params = 'staging'

def params(code):
    env.install_params = code

# check read-access to the keys, to be server-independent
keys = ['~/.ssh/id_rsa']
env.key_filename = [key for key in keys if os.access(key, os.R_OK)]

# this tags the sha deploy
def tag_prod():
    tag = "prod/%s" % strftime("%Y/%m-%d-%H-%M-%S")
    local('git tag -a %s -m "Prod"' % tag)
    local('git push --tags')

def update():
    with cd(env.install_path):
        run('git config --global http.sslVerify false')
        run('git remote prune origin')
        run('git remote update')
        sudo('rm -rf composer.lock')
        sudo('rm -rf deps')
        run('git pull -u origin master')
        sudo('rm -rf composer.lock')
        run('rm -f deps/composer/autoload_namespaces.php')
        sudo('rm -rf app/cache/*')
        sudo('rm -rf app/logs/*')
        run('composer install -o')
        sudo('chown -R www-data:www-data *')
        sudo('chown -R www-data:www-data .*')
        sudo('rm -rf app/cache/*')
        sudo('rm -rf app/logs/*')
        run('php console cache:clear --env=prod')
#        tag = run('git tag -l prod/* | sort | tail -n1')
#        run('git checkout ' + tag)

def install():
    run('mkdir -p %s' % env.install_path)
    run('git clone %s %s' % (repo, env.install_path))
    with cd(env.install_path):
        run('composer install --prefer-dist')
        run('php console doctrine:database:create')
        run('php console doctrine:schema:create')

def deploy():
    if not exists(env.install_path):
        install()

    #tag_prod()
    update()

def prodlike():
    load_prod_db()

def test_prod_local():
    with cd(env.install_path):
        local('rm -f deps/composer/autoload_namespaces.php')
        local('rm -rf app/cache/*')
        local('rm -rf app/logs/*')
        local('composer install -o')
        local('php console --env=prod cache:clear')
        local('php console --env=prod cache:warm')
        #local('php console doctrine:migrations --no-interaction')
        local('rm -rf app/cache/*')
        local('rm -rf app/logs/*')
        local('php console --env=prod cache:clear')
        local('php console --env=prod cache:warm')

def run_tests():
    with cd(env.install_path):
        run('php deps/bin/phpunit')

def run_cache_clear():
    with cd(env.install_path):
        run('php console cache:clear --env=prod')
