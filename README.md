Matthew 7:12
============

So we started Matthew 7:12. It is an open source project. It aims to solve the following situation:

In some countries, the internet is very controlled or minimum. The only way to contribute to an open source project is via email. I have heard that the linux kernel group also work using email and attaching patches. However I don’t think their approach solves this situation in a way that is acceptable for this other people.

Matthew is a server app that takes notices of new changes in a repository and email subscribed users patches attached to it. These patches are zipped and are split so no patch per email is larger than a threshold say 2 MB.

Matthew is also a server app that receives contributions, so not only sends them. Matthew is able to read an email account per project to check whether it has been emailed a patch. Each patch that Matthew reads is converted into a Pull Request to a given branch in a given repo.

The circle of contribution then is pushing code via email from contributors and creating PRs and notifying these users of new changes in the repo so that at any time all they would have to do is to send a patch of their changes or apply a patch received from upstream to continue developing.

Matthew will have options to bootstrap a repo on their locals, so easy download options considering split zips of the specific sections of a repository.

Matthew will use best practices and if you like those you already can tell from the repo here.

Is still under heavy construction and you are summoned to PR it, it is your responsibility how it ends up :)

We will deploy it soon too and test it!

Please contribute, tweak the architecture, add tests, fix problems, opening a PR now!

