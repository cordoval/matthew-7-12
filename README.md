Matthew 7:12
============

The app takes notice of new changes in a repository and emails subscribed users
notifications with patches attached to them. These patches are zipped and split so no email is bigger than 2 MB.
Matthew also receives contributions, so not only it sends them but Matthew is able to read an
email account per project to check whether it has been emailed a patch. Each patch that Matthew reads is converted into
a Pull Request to a given branch in a given repo.
The circle of contribution then is pushing code via email from contributors and creating PRs and notifying these users
of new changes in the repo so that at any time all they would have to do is to send a patch of their changes or apply a
patch received from upstream to continue developing.
Matthew will have options to bootstrap a repo on their locals, so easy download options considering split zips of the
specific sections of a repository.

To run tests:

```bash
curl -SL https://github.com/jolicode/JoliCi/releases/download/v0.2.2/jolici.phar -o jolici.phar
php ./jolici.phar run
```

To use bldr:

```bash
./dev tdd
```

Configuration:

```bash
// webhook should send push events to this url:
http://matthew.gushphp.org/pull
```

```bash
// plug crontab -e
1/* * * * * php console swiftmailer:spool:send
```
