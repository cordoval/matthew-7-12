Matthew 7:12
============

Matthew is a server app that takes notices new changes in a repository and email subscribed users patches via email
notifications. These patches are zipped and are split so no patch per email is larger than a threshold say 2 MB.
Matthew is also a server app that receives contributions, so not only it sends them but Matthew is able to read an
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
