rclone(1) User Manual
Nick Craig-Wood
Sep 30, 2017



RCLONE


[Logo]

Rclone is a command line program to sync files and directories to and
from:

-   Amazon Drive
-   Amazon S3
-   Backblaze B2
-   Box
-   Ceph
-   Dreamhost
-   Dropbox
-   FTP
-   Google Cloud Storage
-   Google Drive
-   HTTP
-   Hubic
-   Memset Memstore
-   Microsoft Azure Blob Storage
-   Microsoft OneDrive
-   Minio
-   OVH
-   Openstack Swift
-   Oracle Cloud Storage
-   QingStor
-   Rackspace Cloud Files
-   SFTP
-   Wasabi
-   Yandex Disk
-   The local filesystem

Features

-   MD5/SHA1 hashes checked at all times for file integrity
-   Timestamps preserved on files
-   Partial syncs supported on a whole file basis
-   Copy mode to just copy new/changed files
-   Sync (one way) mode to make a directory identical
-   Check mode to check for file hash equality
-   Can sync to and from network, eg two different cloud accounts
-   Optional encryption (Crypt)
-   Optional FUSE mount (rclone mount)

Links

-   Home page
-   Github project page for source and bug tracker
-   Rclone Forum
-   Google+ page
-   Downloads



INSTALL


Rclone is a Go program and comes as a single binary file.


Quickstart

-   Download the relevant binary.
-   Unpack and the rclone binary.
-   Run rclone config to setup. See rclone config docs for more details.

See below for some expanded Linux / macOS instructions.

See the Usage section of the docs for how to use rclone, or run
rclone -h.


Linux installation from precompiled binary

Fetch and unpack

    curl -O https://downloads.rclone.org/rclone-current-linux-amd64.zip
    unzip rclone-current-linux-amd64.zip
    cd rclone-*-linux-amd64

Copy binary file

    sudo cp rclone /usr/bin/
    sudo chown root:root /usr/bin/rclone
    sudo chmod 755 /usr/bin/rclone

Install manpage

    sudo mkdir -p /usr/local/share/man/man1
    sudo cp rclone.1 /usr/local/share/man/man1/
    sudo mandb 

Run rclone config to setup. See rclone config docs for more details.

    rclone config


macOS installation from precompiled binary

Download the latest version of rclone.

    cd && curl -O https://downloads.rclone.org/rclone-current-osx-amd64.zip

Unzip the download and cd to the extracted folder.

    unzip -a rclone-current-osx-amd64.zip && cd rclone-*-osx-amd64

Move rclone to your $PATH. You will be prompted for your password.

    sudo mkdir -p /usr/local/bin
    sudo mv rclone /usr/local/bin/

(the mkdir command is safe to run, even if the directory already
exists).

Remove the leftover files.

    cd .. && rm -rf rclone-*-osx-amd64 rclone-current-osx-amd64.zip

Run rclone config to setup. See rclone config docs for more details.

    rclone config


Install from source

Make sure you have at least Go 1.6 installed. Make sure your GOPATH is
set, then:

    go get -u -v github.com/ncw/rclone

and this will build the binary in $GOPATH/bin. If you have built rclone
before then you will want to update its dependencies first with this

    go get -u -v github.com/ncw/rclone/...


Installation with Ansible

This can be done with Stefan Weichinger's ansible role.

Instructions

1.  git clone https://github.com/stefangweichinger/ansible-rclone.git
    into your local roles-directory
2.  add the role to the hosts you want rclone installed to:

        - hosts: rclone-hosts
          roles:
              - rclone


Configure

First, you'll need to configure rclone. As the object storage systems
have quite complicated authentication these are kept in a config file.
(See the --config entry for how to find the config file and choose its
location.)

The easiest way to make the config is to run rclone with the config
option:

    rclone config

See the following for detailed instructions for

-   Amazon Drive
-   Amazon S3
-   Backblaze B2
-   Box
-   Crypt - to encrypt other remotes
-   Dropbox
-   FTP
-   Google Cloud Storage
-   Google Drive
-   HTTP
-   Hubic
-   Microsoft Azure Blob Storage
-   Microsoft OneDrive
-   Openstack Swift / Rackspace Cloudfiles / Memset Memstore
-   QingStor
-   SFTP
-   Yandex Disk
-   The local filesystem


Usage

Rclone syncs a directory tree from one storage system to another.

Its syntax is like this

    Syntax: [options] subcommand <parameters> <parameters...>

Source and destination paths are specified by the name you gave the
storage system in the config file then the sub path, eg "drive:myfolder"
to look at "myfolder" in Google drive.

You can define as many storage paths as you like in the config file.


Subcommands

rclone uses a system of subcommands. For example

    rclone ls remote:path # lists a re
    rclone copy /local/path remote:path # copies /local/path to the remote
    rclone sync /local/path remote:path # syncs /local/path to the remote


rclone config

Enter an interactive configuration session.

Synopsis

rclone config enters an interactive configuration sessions where you can
setup new remotes and manage existing ones. You may also set or remove a
password to protect your configuration.

Additional functions:

-   rclone config edit – same as above
-   rclone config file – show path of configuration file in use
-   rclone config show – print (decrypted) config file

    rclone config [function] [flags]

Options

      -h, --help   help for config


rclone copy

Copy files from source to dest, skipping already copied

Synopsis

Copy the source to the destination. Doesn't transfer unchanged files,
testing by size and modification time or MD5SUM. Doesn't delete files
from the destination.

Note that it is always the contents of the directory that is synced, not
the directory so when source:path is a directory, it's the contents of
source:path that are copied, not the directory name and contents.

If dest:path doesn't exist, it is created and the source:path contents
go there.

For example

    rclone copy source:sourcepath dest:destpath

Let's say there are two files in sourcepath

    sourcepath/one.txt
    sourcepath/two.txt

This copies them to

    destpath/one.txt
    destpath/two.txt

Not to

    destpath/sourcepath/one.txt
    destpath/sourcepath/two.txt

If you are familiar with rsync, rclone always works as if you had
written a trailing / - meaning "copy the contents of this directory".
This applies to all commands and whether you are talking about the
source or destination.

See the --no-traverse option for controlling whether rclone lists the
destination directory or not.

    rclone copy source:path dest:path [flags]

Options

      -h, --help   help for copy


rclone sync

Make source and dest identical, modifying destination only.

Synopsis

Sync the source to the destination, changing the destination only.
Doesn't transfer unchanged files, testing by size and modification time
or MD5SUM. Destination is updated to match source, including deleting
files if necessary.

IMPORTANT: Since this can cause data loss, test first with the --dry-run
flag to see exactly what would be copied and deleted.

Note that files in the destination won't be deleted if there were any
errors at any point.

It is always the contents of the directory that is synced, not the
directory so when source:path is a directory, it's the contents of
source:path that are copied, not the directory name and contents. See
extended explanation in the copy command above if unsure.

If dest:path doesn't exist, it is created and the source:path contents
go there.

    rclone sync source:path dest:path [flags]

Options

      -h, --help   help for sync


rclone move

Move files from source to dest.

Synopsis

Moves the contents of the source directory to the destination directory.
Rclone will error if the source and destination overlap and the remote
does not support a server side directory move operation.

If no filters are in use and if possible this will server side move
source:path into dest:path. After this source:path will no longer longer
exist.

Otherwise for each file in source:path selected by the filters (if any)
this will move it into dest:path. If possible a server side move will be
used, otherwise it will copy it (server side if possible) into dest:path
then delete the original (if no errors on copy) in source:path.

IMPORTANT: Since this can cause data loss, test first with the --dry-run
flag.

    rclone move source:path dest:path [flags]

Options

      -h, --help   help for move


rclone delete

Remove the contents of path.

Synopsis

Remove the contents of path. Unlike purge it obeys include/exclude
filters so can be used to selectively delete files.

Eg delete all files bigger than 100MBytes

Check what would be deleted first (use either)

    rclone --min-size 100M lsl remote:path
    rclone --dry-run --min-size 100M delete remote:path

Then delete

    rclone --min-size 100M delete remote:path

That reads "delete everything with a minimum size of 100 MB", hence
delete all files bigger than 100MBytes.

    rclone delete remote:path [flags]

Options

      -h, --help   help for delete


rclone purge

Remove the path and all of its contents.

Synopsis

Remove the path and all of its contents. Note that this does not obey
include/exclude filters - everything will be removed. Use delete if you
want to selectively delete files.

    rclone purge remote:path [flags]

Options

      -h, --help   help for purge


rclone mkdir

Make the path if it doesn't already exist.

Synopsis

Make the path if it doesn't already exist.

    rclone mkdir remote:path [flags]

Options

      -h, --help   help for mkdir


rclone rmdir

Remove the path if empty.

Synopsis

Remove the path. Note that you can't remove a path with objects in it,
use purge for that.

    rclone rmdir remote:path [flags]

Options

      -h, --help   help for rmdir


rclone check

Checks the files in the source and destination match.

Synopsis

Checks the files in the source and destination match. It compares sizes
and hashes (MD5 or SHA1) and logs a report of files which don't match.
It doesn't alter the source or destination.

If you supply the --size-only flag, it will only compare the sizes not
the hashes as well. Use this for a quick check.

If you supply the --download flag, it will download the data from both
remotes and check them against each other on the fly. This can be useful
for remotes that don't support hashes or if you really want to check all
the data.

    rclone check source:path dest:path [flags]

Options

          --download   Check by downloading rather than with hash.
      -h, --help       help for check


rclone ls

List all the objects in the path with size and path.

Synopsis

List all the objects in the path with size and path.

    rclone ls remote:path [flags]

Options

      -h, --help   help for ls


rclone lsd

List all directories/containers/buckets in the path.

Synopsis

List all directories/containers/buckets in the path.

    rclone lsd remote:path [flags]

Options

      -h, --help   help for lsd


rclone lsl

List all the objects path with modification time, size and path.

Synopsis

List all the objects path with modification time, size and path.

    rclone lsl remote:path [flags]

Options

      -h, --help   help for lsl


rclone md5sum

Produces an md5sum file for all the objects in the path.

Synopsis

Produces an md5sum file for all the objects in the path. This is in the
same format as the standard md5sum tool produces.

    rclone md5sum remote:path [flags]

Options

      -h, --help   help for md5sum


rclone sha1sum

Produces an sha1sum file for all the objects in the path.

Synopsis

Produces an sha1sum file for all the objects in the path. This is in the
same format as the standard sha1sum tool produces.

    rclone sha1sum remote:path [flags]

Options

      -h, --help   help for sha1sum


rclone size

Prints the total size and number of objects in remote:path.

Synopsis

Prints the total size and number of objects in remote:path.

    rclone size remote:path [flags]

Options

      -h, --help   help for size


rclone version

Show the version number.

Synopsis

Show the version number.

    rclone version [flags]

Options

      -h, --help   help for version


rclone cleanup

Clean up the remote if possible

Synopsis

Clean up the remote if possible. Empty the trash or delete old file
versions. Not supported by all remotes.

    rclone cleanup remote:path [flags]

Options

      -h, --help   help for cleanup


rclone dedupe

Interactively find duplicate files delete/rename them.

Synopsis

By default dedupe interactively finds duplicate files and offers to
delete all but one or rename them to be different. Only useful with
Google Drive which can have duplicate file names.

In the first pass it will merge directories with the same name. It will
do this iteratively until all the identical directories have been
merged.

The dedupe command will delete all but one of any identical (same
md5sum) files it finds without confirmation. This means that for most
duplicated files the dedupe command will not be interactive. You can use
--dry-run to see what would happen without doing anything.

Here is an example run.

Before - with duplicates

    $ rclone lsl drive:dupes
      6048320 2016-03-05 16:23:16.798000000 one.txt
      6048320 2016-03-05 16:23:11.775000000 one.txt
       564374 2016-03-05 16:23:06.731000000 one.txt
      6048320 2016-03-05 16:18:26.092000000 one.txt
      6048320 2016-03-05 16:22:46.185000000 two.txt
      1744073 2016-03-05 16:22:38.104000000 two.txt
       564374 2016-03-05 16:22:52.118000000 two.txt

Now the dedupe session

    $ rclone dedupe drive:dupes
    2016/03/05 16:24:37 Google drive root 'dupes': Looking for duplicates using interactive mode.
    one.txt: Found 4 duplicates - deleting identical copies
    one.txt: Deleting 2/3 identical duplicates (md5sum "1eedaa9fe86fd4b8632e2ac549403b36")
    one.txt: 2 duplicates remain
      1:      6048320 bytes, 2016-03-05 16:23:16.798000000, md5sum 1eedaa9fe86fd4b8632e2ac549403b36
      2:       564374 bytes, 2016-03-05 16:23:06.731000000, md5sum 7594e7dc9fc28f727c42ee3e0749de81
    s) Skip and do nothing
    k) Keep just one (choose which in next step)
    r) Rename all to be different (by changing file.jpg to file-1.jpg)
    s/k/r> k
    Enter the number of the file to keep> 1
    one.txt: Deleted 1 extra copies
    two.txt: Found 3 duplicates - deleting identical copies
    two.txt: 3 duplicates remain
      1:       564374 bytes, 2016-03-05 16:22:52.118000000, md5sum 7594e7dc9fc28f727c42ee3e0749de81
      2:      6048320 bytes, 2016-03-05 16:22:46.185000000, md5sum 1eedaa9fe86fd4b8632e2ac549403b36
      3:      1744073 bytes, 2016-03-05 16:22:38.104000000, md5sum 851957f7fb6f0bc4ce76be966d336802
    s) Skip and do nothing
    k) Keep just one (choose which in next step)
    r) Rename all to be different (by changing file.jpg to file-1.jpg)
    s/k/r> r
    two-1.txt: renamed from: two.txt
    two-2.txt: renamed from: two.txt
    two-3.txt: renamed from: two.txt

The result being

    $ rclone lsl drive:dupes
      6048320 2016-03-05 16:23:16.798000000 one.txt
       564374 2016-03-05 16:22:52.118000000 two-1.txt
      6048320 2016-03-05 16:22:46.185000000 two-2.txt
      1744073 2016-03-05 16:22:38.104000000 two-3.txt

Dedupe can be run non interactively using the --dedupe-mode flag or by
using an extra parameter with the same value

-   --dedupe-mode interactive - interactive as above.
-   --dedupe-mode skip - removes identical files then skips
    anything left.
-   --dedupe-mode first - removes identical files then keeps the
    first one.
-   --dedupe-mode newest - removes identical files then keeps the
    newest one.
-   --dedupe-mode oldest - removes identical files then keeps the
    oldest one.
-   --dedupe-mode rename - removes identical files then renames the rest
    to be different.

For example to rename all the identically named photos in your Google
Photos directory, do

    rclone dedupe --dedupe-mode rename "drive:Google Photos"

Or

    rclone dedupe rename "drive:Google Photos"

    rclone dedupe [mode] remote:path [flags]

Options

          --dedupe-mode string   Dedupe mode interactive|skip|first|newest|oldest|rename. (default "interactive")
      -h, --help                 help for dedupe


rclone authorize

Remote authorization.

Synopsis

Remote authorization. Used to authorize a remote or headless rclone from
a machine with a browser - use as instructed by rclone config.

    rclone authorize [flags]

Options

      -h, --help   help for authorize


rclone cat

Concatenates any files and sends them to stdout.

Synopsis

rclone cat sends any files to standard output.

You can use it like this to output a single file

    rclone cat remote:path/to/file

Or like this to output any file in dir or subdirectories.

    rclone cat remote:path/to/dir

Or like this to output any .txt files in dir or subdirectories.

    rclone --include "*.txt" cat remote:path/to/dir

Use the --head flag to print characters only at the start, --tail for
the end and --offset and --count to print a section in the middle. Note
that if offset is negative it will count from the end, so --offset -1
--count 1 is equivalent to --tail 1.

    rclone cat remote:path [flags]

Options

          --count int    Only print N characters. (default -1)
          --discard      Discard the output instead of printing.
          --head int     Only print the first N characters.
      -h, --help         help for cat
          --offset int   Start printing at offset N (or from end if -ve).
          --tail int     Only print the last N characters.


rclone copyto

Copy files from source to dest, skipping already copied

Synopsis

If source:path is a file or directory then it copies it to a file or
directory named dest:path.

This can be used to upload single files to other than their current
name. If the source is a directory then it acts exactly like the copy
command.

So

    rclone copyto src dst

where src and dst are rclone paths, either remote:path or /path/to/local
or C:.

This will:

    if src is file
        copy it to dst, overwriting an existing file if it exists
    if src is directory
        copy it to dst, overwriting existing files if they exist
        see copy command for full details

This doesn't transfer unchanged files, testing by size and modification
time or MD5SUM. It doesn't delete files from the destination.

    rclone copyto source:path dest:path [flags]

Options

      -h, --help   help for copyto


rclone cryptcheck

Cryptcheck checks the integrity of a crypted remote.

Synopsis

rclone cryptcheck checks a remote against a crypted remote. This is the
equivalent of running rclone check, but able to check the checksums of
the crypted remote.

For it to work the underlying remote of the cryptedremote must support
some kind of checksum.

It works by reading the nonce from each file on the cryptedremote: and
using that to encrypt each file on the remote:. It then checks the
checksum of the underlying file on the cryptedremote: against the
checksum of the file it has just encrypted.

Use it like this

    rclone cryptcheck /path/to/files encryptedremote:path

You can use it like this also, but that will involve downloading all the
files in remote:path.

    rclone cryptcheck remote:path encryptedremote:path

After it has run it will log the status of the encryptedremote:.

    rclone cryptcheck remote:path cryptedremote:path [flags]

Options

      -h, --help   help for cryptcheck


rclone cryptdecode

Cryptdecode returns unencrypted file names.

Synopsis

rclone cryptdecode returns unencrypted file names when provided with a
list of encrypted file names. List limit is 10 items.

use it like this

    rclone cryptdecode encryptedremote: encryptedfilename1 encryptedfilename2

    rclone cryptdecode encryptedremote: encryptedfilename [flags]

Options

      -h, --help   help for cryptdecode


rclone dbhashsum

Produces a Dropbbox hash file for all the objects in the path.

Synopsis

Produces a Dropbox hash file for all the objects in the path. The hashes
are calculated according to Dropbox content hash rules. The output is in
the same format as md5sum and sha1sum.

    rclone dbhashsum remote:path [flags]

Options

      -h, --help   help for dbhashsum


rclone genautocomplete

Output completion script for a given shell.

Synopsis

Generates a shell completion script for rclone. Run with --help to list
the supported shells.

Options

      -h, --help   help for genautocomplete


rclone genautocomplete bash

Output bash completion script for rclone.

Synopsis

Generates a bash shell autocompletion script for rclone.

This writes to /etc/bash_completion.d/rclone by default so will probably
need to be run with sudo or as root, eg

    sudo rclone genautocomplete bash

Logout and login again to use the autocompletion scripts, or source them
directly

    . /etc/bash_completion

If you supply a command line argument the script will be written there.

    rclone genautocomplete bash [output_file] [flags]

Options

      -h, --help   help for bash


rclone genautocomplete zsh

Output zsh completion script for rclone.

Synopsis

Generates a zsh autocompletion script for rclone.

This writes to /usr/share/zsh/vendor-completions/_rclone by default so
will probably need to be run with sudo or as root, eg

    sudo rclone genautocomplete zsh

Logout and login again to use the autocompletion scripts, or source them
directly

    autoload -U compinit && compinit

If you supply a command line argument the script will be written there.

    rclone genautocomplete zsh [output_file] [flags]

Options

      -h, --help   help for zsh


rclone gendocs

Output markdown docs for rclone to the directory supplied.

Synopsis

This produces markdown docs for the rclone commands to the directory
supplied. These are in a format suitable for hugo to render into the
rclone.org website.

    rclone gendocs output_directory [flags]

Options

      -h, --help   help for gendocs


rclone listremotes

List all the remotes in the config file.

Synopsis

rclone listremotes lists all the available remotes from the config file.

When uses with the -l flag it lists the types too.

    rclone listremotes [flags]

Options

      -h, --help   help for listremotes
      -l, --long   Show the type as well as names.


rclone lsjson

List directories and objects in the path in JSON format.

Synopsis

List directories and objects in the path in JSON format.

The output is an array of Items, where each Item looks like this

{ "Hashes" : { "SHA-1" : "f572d396fae9206628714fb2ce00f72e94f2258f",
"MD5" : "b1946ac92492d2347c6235b4d2611184", "DropboxHash" :
"ecb65bb98f9d905b70458986c39fcbad7715e5f2fcc3b1f07767d7c83e2438cc" },
"IsDir" : false, "ModTime" : "2017-05-31T16:15:57.034468261+01:00",
"Name" : "file.txt", "Path" : "full/path/goes/here/file.txt", "Size" : 6
}

If --hash is not specified the the Hashes property won't be emitted.

If --no-modtime is specified then ModTime will be blank.

The time is in RFC3339 format with nanosecond precision.

The whole output can be processed as a JSON blob, or alternatively it
can be processed line by line as each item is written one to a line.

    rclone lsjson remote:path [flags]

Options

          --hash         Include hashes in the output (may take longer).
      -h, --help         help for lsjson
          --no-modtime   Don't read the modification time (can speed things up).
      -R, --recursive    Recurse into the listing.


rclone mount

Mount the remote as a mountpoint. EXPERIMENTAL

Synopsis

rclone mount allows Linux, FreeBSD, macOS and Windows to mount any of
Rclone's cloud storage systems as a file system with FUSE.

This is EXPERIMENTAL - use with care.

First set up your remote using rclone config. Check it works with
rclone ls etc.

Start the mount like this

    rclone mount remote:path/to/files /path/to/local/mount

Or on Windows like this where X: is an unused drive letter

    rclone mount remote:path/to/files X:

When the program ends, either via Ctrl+C or receiving a SIGINT or
SIGTERM signal, the mount is automatically stopped.

The umount operation can fail, for example when the mountpoint is busy.
When that happens, it is the user's responsibility to stop the mount
manually with

    # Linux
    fusermount -u /path/to/local/mount
    # OS X
    umount /path/to/local/mount

Installing on Windows

To run rclone mount on Windows, you will need to download and install
WinFsp.

WinFsp is an open source Windows File System Proxy which makes it easy
to write user space file systems for Windows. It provides a FUSE
emulation layer which rclone uses combination with cgofuse. Both of
these packages are by Bill Zissimopoulos who was very helpful during the
implementation of rclone mount for Windows.

Windows caveats

Note that drives created as Administrator are not visible by other
accounts (including the account that was elevated as Administrator). So
if you start a Windows drive from an Administrative Command Prompt and
then try to access the same drive from Explorer (which does not run as
Administrator), you will not be able to see the new drive.

The easiest way around this is to start the drive from a normal command
prompt. It is also possible to start a drive from the SYSTEM account
(using the WinFsp.Launcher infrastructure) which creates drives
accessible for everyone on the system.

Limitations

This can only write files seqentially, it can only seek when reading.
This means that many applications won't work with their files on an
rclone mount.

The bucket based remotes (eg Swift, S3, Google Compute Storage, B2,
Hubic) won't work from the root - you will need to specify a bucket, or
a path within the bucket. So swift: won't work whereas swift:bucket will
as will swift:bucket/path. None of these support the concept of
directories, so empty directories will have a tendency to disappear once
they fall out of the directory cache.

Only supported on Linux, FreeBSD, OS X and Windows at the moment.

rclone mount vs rclone sync/copy

File systems expect things to be 100% reliable, whereas cloud storage
systems are a long way from 100% reliable. The rclone sync/copy commands
cope with this with lots of retries. However rclone mount can't use
retries in the same way without making local copies of the uploads. This
might happen in the future, but for the moment rclone mount won't do
that, so will be less reliable than the rclone command.

Filters

Note that all the rclone filters can be used to select a subset of the
files to be visible in the mount.

Directory Cache

Using the --dir-cache-time flag, you can set how long a directory should
be considered up to date and not refreshed from the backend. Changes
made locally in the mount may appear immediately or invalidate the
cache. However, changes done on the remote will only be picked up once
the cache expires.

Alternatively, you can send a SIGHUP signal to rclone for it to flush
all directory caches, regardless of how old they are. Assuming only one
rclone instance is running, you can reset the cache like this:

    kill -SIGHUP $(pidof rclone)

    rclone mount remote:path /path/to/mountpoint [flags]

Options

          --allow-non-empty           Allow mounting over a non-empty directory.
          --allow-other               Allow access to other users.
          --allow-root                Allow access to root user.
          --debug-fuse                Debug the FUSE internals - needs -v.
          --default-permissions       Makes kernel enforce access control based on the file mode.
          --dir-cache-time duration   Time to cache directory entries for. (default 5m0s)
          --fuse-flag stringArray     Flags or arguments to be passed direct to libfuse/WinFsp. Repeat if required.
          --gid uint32                Override the gid field set by the filesystem. (default 502)
      -h, --help                      help for mount
          --max-read-ahead int        The number of bytes that can be prefetched for sequential reads. (default 128k)
          --no-checksum               Don't compare checksums on up/download.
          --no-modtime                Don't read/write the modification time (can speed things up).
          --no-seek                   Don't allow seeking in files.
      -o, --option stringArray        Option for libfuse/WinFsp. Repeat if required.
          --poll-interval duration    Time to wait between polling for changes. Must be smaller than dir-cache-time. Only on supported remotes. Set to 0 to disable. (default 1m0s)
          --read-only                 Mount read-only.
          --uid uint32                Override the uid field set by the filesystem. (default 502)
          --umask int                 Override the permission bits set by the filesystem.
          --write-back-cache          Makes kernel buffer writes before sending them to rclone. Without this, writethrough caching is used.


rclone moveto

Move file or directory from source to dest.

Synopsis

If source:path is a file or directory then it moves it to a file or
directory named dest:path.

This can be used to rename files or upload single files to other than
their existing name. If the source is a directory then it acts exacty
like the move command.

So

    rclone moveto src dst

where src and dst are rclone paths, either remote:path or /path/to/local
or C:.

This will:

    if src is file
        move it to dst, overwriting an existing file if it exists
    if src is directory
        move it to dst, overwriting existing files if they exist
        see move command for full details

This doesn't transfer unchanged files, testing by size and modification
time or MD5SUM. src will be deleted on successful transfer.

IMPORTANT: Since this can cause data loss, test first with the --dry-run
flag.

    rclone moveto source:path dest:path [flags]

Options

      -h, --help   help for moveto


rclone ncdu

Explore a remote with a text based user interface.

Synopsis

This displays a text based user interface allowing the navigation of a
remote. It is most useful for answering the question - "What is using
all my disk space?".

To make the user interface it first scans the entire remote given and
builds an in memory representation. rclone ncdu can be used during this
scanning phase and you will see it building up the directory structure
as it goes along.

Here are the keys - press '?' to toggle the help on and off

     ↑,↓ or k,j to Move
     →,l to enter
     ←,h to return
     c toggle counts
     g toggle graph
     n,s,C sort by name,size,count
     ? to toggle help on and off
     q/ESC/c-C to quit

This an homage to the ncdu tool but for rclone remotes. It is missing
lots of features at the moment, most importantly deleting files, but is
useful as it stands.

    rclone ncdu remote:path [flags]

Options

      -h, --help   help for ncdu


rclone obscure

Obscure password for use in the rclone.conf

Synopsis

Obscure password for use in the rclone.conf

    rclone obscure password [flags]

Options

      -h, --help   help for obscure


rclone rcat

Copies standard input to file on remote.

Synopsis

rclone rcat reads from standard input (stdin) and copies it to a single
remote file.

    echo "hello world" | rclone rcat remote:path/to/file
    ffmpeg - | rclone rcat --checksum remote:path/to/file

If the remote file already exists, it will be overwritten.

rcat will try to upload small files in a single request, which is
usually more efficient than the streaming/chunked upload endpoints,
which use multiple requests. Exact behaviour depends on the remote. What
is considered a small file may be set through --streaming-upload-cutoff.
Uploading only starts after the cutoff is reached or if the file ends
before that. The data must fit into RAM. The cutoff needs to be small
enough to adhere the limits of your remote, please see there. Generally
speaking, setting this cutoff too high will decrease your performance.

Note that the upload can also not be retried because the data is not
kept around until the upload succeeds. If you need to transfer a lot of
data, you're better off caching locally and then rclone move it to the
destination.

    rclone rcat remote:path [flags]

Options

      -h, --help   help for rcat


rclone rmdirs

Remove empty directories under the path.

Synopsis

This removes any empty directories (or directories that only contain
empty directories) under the path that it finds, including the path if
it has nothing in.

This is useful for tidying up remotes that rclone has left a lot of
empty directories in.

    rclone rmdirs remote:path [flags]

Options

      -h, --help   help for rmdirs


rclone tree

List the contents of the remote in a tree like fashion.

Synopsis

rclone tree lists the contents of a remote in a similar way to the unix
tree command.

For example

    $ rclone tree remote:path
    /
    ├── file1
    ├── file2
    ├── file3
    └── subdir
        ├── file4
        └── file5

    1 directories, 5 files

You can use any of the filtering options with the tree command (eg
--include and --exclude). You can also use --fast-list.

The tree command has many options for controlling the listing which are
compatible with the tree command. Note that not all of them have short
options as they conflict with rclone's short options.

    rclone tree remote:path [flags]

Options

      -a, --all             All files are listed (list . files too).
      -C, --color           Turn colorization on always.
      -d, --dirs-only       List directories only.
          --dirsfirst       List directories before files (-U disables).
          --full-path       Print the full path prefix for each file.
      -h, --help            help for tree
          --human           Print the size in a more human readable way.
          --level int       Descend only level directories deep.
      -D, --modtime         Print the date of last modification.
      -i, --noindent        Don't print indentation lines.
          --noreport        Turn off file/directory count at end of tree listing.
      -o, --output string   Output to file instead of stdout.
      -p, --protections     Print the protections for each file.
      -Q, --quote           Quote filenames with double quotes.
      -s, --size            Print the size in bytes of each file.
          --sort string     Select sort: name,version,size,mtime,ctime.
          --sort-ctime      Sort files by last status change time.
      -t, --sort-modtime    Sort files by last modification time.
      -r, --sort-reverse    Reverse the order of the sort.
      -U, --unsorted        Leave files unsorted.
          --version         Sort files alphanumerically by version.


Copying single files

rclone normally syncs or copies directories. However, if the source
remote points to a file, rclone will just copy that file. The
destination remote must point to a directory - rclone will give the
error
Failed to create file system for "remote:file": is a file not a directory
if it isn't.

For example, suppose you have a remote with a file in called test.jpg,
then you could copy just that file like this

    rclone copy remote:test.jpg /tmp/download

The file test.jpg will be placed inside /tmp/download.

This is equivalent to specifying

    rclone copy --no-traverse --files-from /tmp/files remote: /tmp/download

Where /tmp/files contains the single line

    test.jpg

It is recommended to use copy when copying individual files, not sync.
They have pretty much the same effect but copy will use a lot less
memory.


Quoting and the shell

When you are typing commands to your computer you are using something
called the command line shell. This interprets various characters in an
OS specific way.

Here are some gotchas which may help users unfamiliar with the shell
rules

Linux / OSX

If your names have spaces or shell metacharacters (eg *, ?, $, ', " etc)
then you must quote them. Use single quotes ' by default.

    rclone copy 'Important files?' remote:backup

If you want to send a ' you will need to use ", eg

    rclone copy "O'Reilly Reviews" remote:backup

The rules for quoting metacharacters are complicated and if you want the
full details you'll have to consult the manual page for your shell.

Windows

If your names have spaces in you need to put them in ", eg

    rclone copy "E:\folder name\folder name\folder name" remote:backup

If you are using the root directory on its own then don't quote it (see
#464 for why), eg

    rclone copy E:\ remote:backup


Copying files or directories with : in the names

rclone uses : to mark a remote name. This is, however, a valid filename
component in non-Windows OSes. The remote name parser will only search
for a : up to the first / so if you need to act on a file or directory
like this then use the full path starting with a /, or use ./ as a
current directory prefix.

So to sync a directory called sync:me to a remote called remote: use

    rclone sync ./sync:me remote:path

or

    rclone sync /full/path/to/sync:me remote:path


Server Side Copy

Most remotes (but not all - see the overview) support server side copy.

This means if you want to copy one folder to another then rclone won't
download all the files and re-upload them; it will instruct the server
to copy them in place.

Eg

    rclone copy s3:oldbucket s3:newbucket

Will copy the contents of oldbucket to newbucket without downloading and
re-uploading.

Remotes which don't support server side copy WILL download and re-upload
in this case.

Server side copies are used with sync and copy and will be identified in
the log when using the -v flag. The move command may also use them if
remote doesn't support server side move directly. This is done by
issuing a server side copy then a delete which is much quicker than a
download and re-upload.

Server side copies will only be attempted if the remote names are the
same.

This can be used when scripting to make aged backups efficiently, eg

    rclone sync remote:current-backup remote:previous-backup
    rclone sync /path/to/files remote:current-backup


Options

Rclone has a number of options to control its behaviour.

Options which use TIME use the go time parser. A duration string is a
possibly signed sequence of decimal numbers, each with optional fraction
and a unit suffix, such as "300ms", "-1.5h" or "2h45m". Valid time units
are "ns", "us" (or "µs"), "ms", "s", "m", "h".

Options which use SIZE use kByte by default. However, a suffix of b for
bytes, k for kBytes, M for MBytes and G for GBytes may be used. These
are the binary units, eg 1, 2**10, 2**20, 2**30 respectively.

--backup-dir=DIR

When using sync, copy or move any files which would have been
overwritten or deleted are moved in their original hierarchy into this
directory.

If --suffix is set, then the moved files will have the suffix added to
them. If there is a file with the same path (after the suffix has been
added) in DIR, then it will be overwritten.

The remote in use must support server side move or copy and you must use
the same remote as the destination of the sync. The backup directory
must not overlap the destination directory.

For example

    rclone sync /path/to/local remote:current --backup-dir remote:old

will sync /path/to/local to remote:current, but for any files which
would have been updated or deleted will be stored in remote:old.

If running rclone from a script you might want to use today's date as
the directory name passed to --backup-dir to store the old files, or you
might want to pass --suffix with today's date.

--bind string

Local address to bind to for outgoing connections. This can be an IPv4
address (1.2.3.4), an IPv6 address (1234::789A) or host name. If the
host name doesn't resolve or resoves to more than one IP address it will
give an error.

--bwlimit=BANDWIDTH_SPEC

This option controls the bandwidth limit. Limits can be specified in two
ways: As a single limit, or as a timetable.

Single limits last for the duration of the session. To use a single
limit, specify the desired bandwidth in kBytes/s, or use a suffix
b|k|M|G. The default is 0 which means to not limit bandwidth.

For example, to limit bandwidth usage to 10 MBytes/s use --bwlimit 10M

It is also possible to specify a "timetable" of limits, which will cause
certain limits to be applied at certain times. To specify a timetable,
format your entries as "HH:MM,BANDWIDTH HH:MM,BANDWIDTH...".

An example of a typical timetable to avoid link saturation during
daytime working hours could be:

--bwlimit "08:00,512 12:00,10M 13:00,512 18:00,30M 23:00,off"

In this example, the transfer bandwidth will be set to 512kBytes/sec at
8am. At noon, it will raise to 10Mbytes/s, and drop back to
512kBytes/sec at 1pm. At 6pm, the bandwidth limit will be set to
30MBytes/s, and at 11pm it will be completely disabled (full speed).
Anything between 11pm and 8am will remain unlimited.

Bandwidth limits only apply to the data transfer. They don't apply to
the bandwidth of the directory listings etc.

Note that the units are Bytes/s, not Bits/s. Typically connections are
measured in Bits/s - to convert divide by 8. For example, let's say you
have a 10 Mbit/s connection and you wish rclone to use half of it - 5
Mbit/s. This is 5/8 = 0.625MByte/s so you would use a --bwlimit 0.625M
parameter for rclone.

On Unix systems (Linux, MacOS, …) the bandwidth limiter can be toggled
by sending a SIGUSR2 signal to rclone. This allows to remove the
limitations of a long running rclone transfer and to restore it back to
the value specified with --bwlimit quickly when needed. Assuming there
is only one rclone instance running, you can toggle the limiter like
this:

    kill -SIGUSR2 $(pidof rclone)

--buffer-size=SIZE

Use this sized buffer to speed up file transfers. Each --transfer will
use this much memory for buffering.

Set to 0 to disable the buffering for the minimum memory usage.

--checkers=N

The number of checkers to run in parallel. Checkers do the equality
checking of files during a sync. For some storage systems (eg S3, Swift,
Dropbox) this can take a significant amount of time so they are run in
parallel.

The default is to run 8 checkers in parallel.

-c, --checksum

Normally rclone will look at modification time and size of files to see
if they are equal. If you set this flag then rclone will check the file
hash and size to determine if files are equal.

This is useful when the remote doesn't support setting modified time and
a more accurate sync is desired than just checking the file size.

This is very useful when transferring between remotes which store the
same hash type on the object, eg Drive and Swift. For details of which
remotes support which hash type see the table in the overview section.

Eg rclone --checksum sync s3:/bucket swift:/bucket would run much
quicker than without the --checksum flag.

When using this flag, rclone won't update mtimes of remote files if they
are incorrect as it would normally.

--config=CONFIG_FILE

Specify the location of the rclone config file.

Normally the config file is in your home directory as a file called
.config/rclone/rclone.conf (or .rclone.conf if created with an older
version). If $XDG_CONFIG_HOME is set it will be at
$XDG_CONFIG_HOME/rclone/rclone.conf

If you run rclone -h and look at the help for the --config option you
will see where the default location is for you.

Use this flag to override the config location, eg
rclone --config=".myconfig" .config.

--contimeout=TIME

Set the connection timeout. This should be in go time format which looks
like 5s for 5 seconds, 10m for 10 minutes, or 3h30m.

The connection timeout is the amount of time rclone will wait for a
connection to go through to a remote object storage system. It is 1m by
default.

--dedupe-mode MODE

Mode to run dedupe command in. One of interactive, skip, first, newest,
oldest, rename. The default is interactive. See the dedupe command for
more information as to what these options mean.

--disable FEATURE,FEATURE,...

This disables a comma separated list of optional features. For example
to disable server side move and server side copy use:

    --disable move,copy

The features can be put in in any case.

To see a list of which features can be disabled use:

    --disable help

See the overview features and optional features to get an idea of which
feature does what.

This flag can be useful for debugging and in exceptional circumstances
(eg Google Drive limiting the total volume of Server Side Copies to
100GB/day).

-n, --dry-run

Do a trial run with no permanent changes. Use this to see what rclone
would do without actually doing it. Useful when setting up the sync
command which deletes files in the destination.

--ignore-checksum

Normally rclone will check that the checksums of transferred files
match, and give an error "corrupted on transfer" if they don't.

You can use this option to skip that check. You should only use it if
you have had the "corrupted on transfer" error message and you are sure
you might want to transfer potentially corrupted data.

--ignore-existing

Using this option will make rclone unconditionally skip all files that
exist on the destination, no matter the content of these files.

While this isn't a generally recommended option, it can be useful in
cases where your files change due to encryption. However, it cannot
correct partial transfers in case a transfer was interrupted.

--ignore-size

Normally rclone will look at modification time and size of files to see
if they are equal. If you set this flag then rclone will check only the
modification time. If --checksum is set then it only checks the
checksum.

It will also cause rclone to skip verifying the sizes are the same after
transfer.

This can be useful for transferring files to and from OneDrive which
occasionally misreports the size of image files (see #399 for more
info).

-I, --ignore-times

Using this option will cause rclone to unconditionally upload all files
regardless of the state of files on the destination.

Normally rclone would skip any files that have the same modification
time and are the same size (or have the same checksum if using
--checksum).

--immutable

Treat source and destination files as immutable and disallow
modification.

With this option set, files will be created and deleted as requested,
but existing files will never be updated. If an existing file does not
match between the source and destination, rclone will give the error
Source and destination exist but do not match: immutable file modified.

Note that only commands which transfer files (e.g. sync, copy, move) are
affected by this behavior, and only modification is disallowed. Files
may still be deleted explicitly (e.g. delete, purge) or implicitly (e.g.
sync, move). Use copy --immutable if it is desired to avoid deletion as
well as modification.

This can be useful as an additional layer of protection for immutable or
append-only data sets (notably backup archives), where modification
implies corruption and should not be propagated.

--log-file=FILE

Log all of rclone's output to FILE. This is not active by default. This
can be useful for tracking down problems with syncs in combination with
the -v flag. See the Logging section for more info.

--log-level LEVEL

This sets the log level for rclone. The default log level is INFO.

DEBUG is equivalent to -vv. It outputs lots of debug info - useful for
bug reports and really finding out what rclone is doing.

INFO is equivalent to -v. It outputs information about each transfer and
prints stats once a minute by default.

NOTICE is the default log level if no logging flags are supplied. It
outputs very little when things are working normally. It outputs
warnings and significant events.

ERROR is equivalent to -q. It only outputs error messages.

--low-level-retries NUMBER

This controls the number of low level retries rclone does.

A low level retry is used to retry a failing operation - typically one
HTTP request. This might be uploading a chunk of a big file for example.
You will see low level retries in the log with the -v flag.

This shouldn't need to be changed from the default in normal operations.
However, if you get a lot of low level retries you may wish to reduce
the value so rclone moves on to a high level retry (see the --retries
flag) quicker.

Disable low level retries with --low-level-retries 1.

--max-depth=N

This modifies the recursion depth for all the commands except purge.

So if you do rclone --max-depth 1 ls remote:path you will see only the
files in the top level directory. Using --max-depth 2 means you will see
all the files in first two directory levels and so on.

For historical reasons the lsd command defaults to using a --max-depth
of 1 - you can override this with the command line flag.

You can use this command to disable recursion (with --max-depth 1).

Note that if you use this with sync and --delete-excluded the files not
recursed through are considered excluded and will be deleted on the
destination. Test first with --dry-run if you are not sure what will
happen.

--modify-window=TIME

When checking whether a file has been modified, this is the maximum
allowed time difference that a file can have and still be considered
equivalent.

The default is 1ns unless this is overridden by a remote. For example OS
X only stores modification times to the nearest second so if you are
reading and writing to an OS X filing system this will be 1s by default.

This command line flag allows you to override that computed default.

--no-gzip-encoding

Don't set Accept-Encoding: gzip. This means that rclone won't ask the
server for compressed files automatically. Useful if you've set the
server to return files with Content-Encoding: gzip but you uploaded
compressed files.

There is no need to set this in normal operation, and doing so will
decrease the network transfer efficiency of rclone.

--no-update-modtime

When using this flag, rclone won't update modification times of remote
files if they are incorrect as it would normally.

This can be used if the remote is being synced with another tool also
(eg the Google Drive client).

-q, --quiet

Normally rclone outputs stats and a completion message. If you set this
flag it will make as little output as possible.

--retries int

Retry the entire sync if it fails this many times it fails (default 3).

Some remotes can be unreliable and a few retries help pick up the files
which didn't get transferred because of errors.

Disable retries with --retries 1.

--size-only

Normally rclone will look at modification time and size of files to see
if they are equal. If you set this flag then rclone will check only the
size.

This can be useful transferring files from Dropbox which have been
modified by the desktop sync client which doesn't set checksums of
modification times in the same way as rclone.

--stats=TIME

Commands which transfer data (sync, copy, copyto, move, moveto) will
print data transfer stats at regular intervals to show their progress.

This sets the interval.

The default is 1m. Use 0 to disable.

If you set the stats interval then all commands can show stats. This can
be useful when running other commands, check or mount for example.

Stats are logged at INFO level by default which means they won't show at
default log level NOTICE. Use --stats-log-level NOTICE or -v to make
them show. See the Logging section for more info on log levels.

--stats-log-level string

Log level to show --stats output at. This can be DEBUG, INFO, NOTICE, or
ERROR. The default is INFO. This means at the default level of logging
which is NOTICE the stats won't show - if you want them to then use
-stats-log-level NOTICE. See the Logging section for more info on log
levels.

--stats-unit=bits|bytes

By default, data transfer rates will be printed in bytes/second.

This option allows the data rate to be printed in bits/second.

Data transfer volume will still be reported in bytes.

The rate is reported as a binary unit, not SI unit. So 1 Mbit/s equals
1,048,576 bits/s and not 1,000,000 bits/s.

The default is bytes.

--suffix=SUFFIX

This is for use with --backup-dir only. If this isn't set then
--backup-dir will move files with their original name. If it is set then
the files will have SUFFIX added on to them.

See --backup-dir for more info.

--syslog

On capable OSes (not Windows or Plan9) send all log output to syslog.

This can be useful for running rclone in a script or rclone mount.

--syslog-facility string

If using --syslog this sets the syslog facility (eg KERN, USER). See
man syslog for a list of possible facilities. The default facility is
DAEMON.

--tpslimit float

Limit HTTP transactions per second to this. Default is 0 which is used
to mean unlimited transactions per second.

For example to limit rclone to 10 HTTP transactions per second use
--tpslimit 10, or to 1 transaction every 2 seconds use --tpslimit 0.5.

Use this when the number of transactions per second from rclone is
causing a problem with the cloud storage provider (eg getting you banned
or rate limited).

This can be very useful for rclone mount to control the behaviour of
applications using it.

See also --tpslimit-burst.

--tpslimit-burst int

Max burst of transactions for --tpslimit. (default 1)

Normally --tpslimit will do exactly the number of transaction per second
specified. However if you supply --tps-burst then rclone can save up
some transactions from when it was idle giving a burst of up to the
parameter supplied.

For example if you provide --tpslimit-burst 10 then if rclone has been
idle for more than 10*--tpslimit then it can do 10 transactions very
quickly before they are limited again.

This may be used to increase performance of --tpslimit without changing
the long term average number of transactions per second.

--track-renames

By default, rclone doesn't keep track of renamed files, so if you rename
a file locally then sync it to a remote, rclone will delete the old file
on the remote and upload a new copy.

If you use this flag, and the remote supports server side copy or server
side move, and the source and destination have a compatible hash, then
this will track renames during sync, copy, and move operations and
perform renaming server-side.

Files will be matched by size and hash - if both match then a rename
will be considered.

If the destination does not support server-side copy or move, rclone
will fall back to the default behaviour and log an error level message
to the console.

Note that --track-renames is incompatible with --no-traverse and that it
uses extra memory to keep track of all the rename candidates.

Note also that --track-renames is incompatible with --delete-before and
will select --delete-after instead of --delete-during.

--delete-(before,during,after)

This option allows you to specify when files on your destination are
deleted when you sync folders.

Specifying the value --delete-before will delete all files present on
the destination, but not on the source _before_ starting the transfer of
any new or updated files. This uses two passes through the file systems,
one for the deletions and one for the copies.

Specifying --delete-during will delete files while checking and
uploading files. This is the fastest option and uses the least memory.

Specifying --delete-after (the default value) will delay deletion of
files until all new/updated files have been successfully transferred.
The files to be deleted are collected in the copy pass then deleted
after the copy pass has completed successfully. The files to be deleted
are held in memory so this mode may use more memory. This is the safest
mode as it will only delete files if there have been no errors
subsequent to that. If there have been errors before the deletions start
then you will get the message
not deleting files as there were IO errors.

--fast-list

When doing anything which involves a directory listing (eg sync, copy,
ls - in fact nearly every command), rclone normally lists a directory
and processes it before using more directory lists to process any
subdirectories. This can be parallelised and works very quickly using
the least amount of memory.

However, some remotes have a way of listing all files beneath a
directory in one (or a small number) of transactions. These tend to be
the bucket based remotes (eg S3, B2, GCS, Swift, Hubic).

If you use the --fast-list flag then rclone will use this method for
listing directories. This will have the following consequences for the
listing:

-   It WILL use fewer transactions (important if you pay for them)
-   It WILL use more memory. Rclone has to load the whole listing
    into memory.
-   It _may_ be faster because it uses fewer transactions
-   It _may_ be slower because it can't be parallelized

rclone should always give identical results with and without
--fast-list.

If you pay for transactions and can fit your entire sync listing into
memory then --fast-list is recommended. If you have a very big sync to
do then don't use --fast-list otherwise you will run out of memory.

If you use --fast-list on a remote which doesn't support it, then rclone
will just ignore it.

--timeout=TIME

This sets the IO idle timeout. If a transfer has started but then
becomes idle for this long it is considered broken and disconnected.

The default is 5m. Set to 0 to disable.

--transfers=N

The number of file transfers to run in parallel. It can sometimes be
useful to set this to a smaller number if the remote is giving a lot of
timeouts or bigger if you have lots of bandwidth and a fast remote.

The default is to run 4 file transfers in parallel.

-u, --update

This forces rclone to skip any files which exist on the destination and
have a modified time that is newer than the source file.

If an existing destination file has a modification time equal (within
the computed modify window precision) to the source file's, it will be
updated if the sizes are different.

On remotes which don't support mod time directly the time checked will
be the uploaded time. This means that if uploading to one of these
remotes, rclone will skip any files which exist on the destination and
have an uploaded time that is newer than the modification time of the
source file.

This can be useful when transferring to a remote which doesn't support
mod times directly as it is more accurate than a --size-only check and
faster than using --checksum.

-v, -vv, --verbose

With -v rclone will tell you about each file that is transferred and a
small number of significant events.

With -vv rclone will become very verbose telling you about every file it
considers and transfers. Please send bug reports with a log with this
setting.

-V, --version

Prints the version number


Configuration Encryption

Your configuration file contains information for logging in to your
cloud services. This means that you should keep your .rclone.conf file
in a secure location.

If you are in an environment where that isn't possible, you can add a
password to your configuration. This means that you will have to enter
the password every time you start rclone.

To add a password to your rclone configuration, execute rclone config.

    >rclone config
    Current remotes:

    e) Edit existing remote
    n) New remote
    d) Delete remote
    s) Set configuration password
    q) Quit config
    e/n/d/s/q>

Go into s, Set configuration password:

    e/n/d/s/q> s
    Your configuration is not encrypted.
    If you add a password, you will protect your login information to cloud services.
    a) Add Password
    q) Quit to main menu
    a/q> a
    Enter NEW configuration password:
    password:
    Confirm NEW password:
    password:
    Password set
    Your configuration is encrypted.
    c) Change Password
    u) Unencrypt configuration
    q) Quit to main menu
    c/u/q>

Your configuration is now encrypted, and every time you start rclone you
will now be asked for the password. In the same menu, you can change the
password or completely remove encryption from your configuration.

There is no way to recover the configuration if you lose your password.

rclone uses nacl secretbox which in turn uses XSalsa20 and Poly1305 to
encrypt and authenticate your configuration with secret-key
cryptography. The password is SHA-256 hashed, which produces the key for
secretbox. The hashed password is not stored.

While this provides very good security, we do not recommend storing your
encrypted rclone configuration in public if it contains sensitive
information, maybe except if you use a very strong password.

If it is safe in your environment, you can set the RCLONE_CONFIG_PASS
environment variable to contain your password, in which case it will be
used for decrypting the configuration.

You can set this for a session from a script. For unix like systems save
this to a file called set-rclone-password:

    #!/bin/echo Source this file don't run it

    read -s RCLONE_CONFIG_PASS
    export RCLONE_CONFIG_PASS

Then source the file when you want to use it. From the shell you would
do source set-rclone-password. It will then ask you for the password and
set it in the environment variable.

If you are running rclone inside a script, you might want to disable
password prompts. To do that, pass the parameter --ask-password=false to
rclone. This will make rclone fail instead of asking for a password if
RCLONE_CONFIG_PASS doesn't contain a valid password.


Developer options

These options are useful when developing or debugging rclone. There are
also some more remote specific options which aren't documented here
which are used for testing. These start with remote name eg
--drive-test-option - see the docs for the remote in question.

--cpuprofile=FILE

Write CPU profile to file. This can be analysed with go tool pprof.

--dump-auth

Dump HTTP headers - will contain sensitive info such as Authorization:
headers - use --dump-headers to dump without Authorization: headers. Can
be very verbose. Useful for debugging only.

--dump-bodies

Dump HTTP headers and bodies - may contain sensitive info. Can be very
verbose. Useful for debugging only.

Note that the bodies are buffered in memory so don't use this for
enormous files.

--dump-filters

Dump the filters to the output. Useful to see exactly what include and
exclude options are filtering on.

--dump-headers

Dump HTTP headers with Authorization: lines removed. May still contain
sensitive info. Can be very verbose. Useful for debugging only.

Use --dump-auth if you do want the Authorization: headers.

--memprofile=FILE

Write memory profile to file. This can be analysed with go tool pprof.

--no-check-certificate=true/false

--no-check-certificate controls whether a client verifies the server's
certificate chain and host name. If --no-check-certificate is true, TLS
accepts any certificate presented by the server and any host name in
that certificate. In this mode, TLS is susceptible to man-in-the-middle
attacks.

This option defaults to false.

THIS SHOULD BE USED ONLY FOR TESTING.

--no-traverse

The --no-traverse flag controls whether the destination file system is
traversed when using the copy or move commands. --no-traverse is not
compatible with sync and will be ignored if you supply it with sync.

If you are only copying a small number of files and/or have a large
number of files on the destination then --no-traverse will stop rclone
listing the destination and save time.

However, if you are copying a large number of files, especially if you
are doing a copy where lots of the files haven't changed and won't need
copying then you shouldn't use --no-traverse.

It can also be used to reduce the memory usage of rclone when copying -
rclone --no-traverse copy src dst won't load either the source or
destination listings into memory so will use the minimum amount of
memory.


Filtering

For the filtering options

-   --delete-excluded
-   --filter
-   --filter-from
-   --exclude
-   --exclude-from
-   --include
-   --include-from
-   --files-from
-   --min-size
-   --max-size
-   --min-age
-   --max-age
-   --dump-filters

See the filtering section.


Logging

rclone has 4 levels of logging, Error, Notice, Info and Debug.

By default, rclone logs to standard error. This means you can redirect
standard error and still see the normal output of rclone commands (eg
rclone ls).

By default, rclone will produce Error and Notice level messages.

If you use the -q flag, rclone will only produce Error messages.

If you use the -v flag, rclone will produce Error, Notice and Info
messages.

If you use the -vv flag, rclone will produce Error, Notice, Info and
Debug messages.

You can also control the log levels with the --log-level flag.

If you use the --log-file=FILE option, rclone will redirect Error, Info
and Debug messages along with standard error to FILE.

If you use the --syslog flag then rclone will log to syslog and the
--syslog-facility control which facility it uses.

Rclone prefixes all log messages with their level in capitals, eg INFO
which makes it easy to grep the log file for different kinds of
information.


Exit Code

If any errors occur during the command execution, rclone will exit with
a non-zero exit code. This allows scripts to detect when rclone
operations have failed.

During the startup phase, rclone will exit immediately if an error is
detected in the configuration. There will always be a log message
immediately before exiting.

When rclone is running it will accumulate errors as it goes along, and
only exit with a non-zero exit code if (after retries) there were still
failed transfers. For every error counted there will be a high priority
log message (visible with -q) showing the message and which file caused
the problem. A high priority message is also shown when starting a retry
so the user can see that any previous error messages may not be valid
after the retry. If rclone has done a retry it will log a high priority
message if the retry was successful.


Environment Variables

Rclone can be configured entirely using environment variables. These can
be used to set defaults for options or config file entries.

Options

Every option in rclone can have its default set by environment variable.

To find the name of the environment variable, first, take the long
option name, strip the leading --, change - to _, make upper case and
prepend RCLONE_.

For example, to always set --stats 5s, set the environment variable
RCLONE_STATS=5s. If you set stats on the command line this will override
the environment variable setting.

Or to always use the trash in drive --drive-use-trash, set
RCLONE_DRIVE_USE_TRASH=true.

The same parser is used for the options and the environment variables so
they take exactly the same form.

Config file

You can set defaults for values in the config file on an individual
remote basis. If you want to use this feature, you will need to discover
the name of the config items that you want. The easiest way is to run
through rclone config by hand, then look in the config file to see what
the values are (the config file can be found by looking at the help for
--config in rclone help).

To find the name of the environment variable, you need to set, take
RCLONE_ + name of remote + _ + name of config file option and make it
all uppercase.

For example, to configure an S3 remote named mys3: without a config file
(using unix ways of setting environment variables):

    $ export RCLONE_CONFIG_MYS3_TYPE=s3
    $ export RCLONE_CONFIG_MYS3_ACCESS_KEY_ID=XXX
    $ export RCLONE_CONFIG_MYS3_SECRET_ACCESS_KEY=XXX
    $ rclone lsd MYS3:
              -1 2016-09-21 12:54:21        -1 my-bucket
    $ rclone listremotes | grep mys3
    mys3:

Note that if you want to create a remote using environment variables you
must create the ..._TYPE variable as above.

Other environment variables

-   RCLONE_CONFIG_PASS` set to contain your config file password (see
    Configuration Encryption section)
-   HTTP_PROXY, HTTPS_PROXY and NO_PROXY (or the lowercase
    versions thereof).
    -   HTTPS_PROXY takes precedence over HTTP_PROXY for https requests.
    -   The environment values may be either a complete URL or a
        "host[:port]" for, in which case the "http" scheme is assumed.



CONFIGURING RCLONE ON A REMOTE / HEADLESS MACHINE


Some of the configurations (those involving oauth2) require an Internet
connected web browser.

If you are trying to set rclone up on a remote or headless box with no
browser available on it (eg a NAS or a server in a datacenter) then you
will need to use an alternative means of configuration. There are two
ways of doing it, described below.


Configuring using rclone authorize

On the headless box

    ...
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> n
    For this to work, you will need rclone available on a machine that has a web browser available.
    Execute the following on your machine:
        rclone authorize "amazon cloud drive"
    Then paste the result below:
    result>

Then on your main desktop machine

    rclone authorize "amazon cloud drive"
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    Paste the following into your remote machine --->
    SECRET_TOKEN
    <---End paste

Then back to the headless box, paste in the code

    result> SECRET_TOKEN
    --------------------
    [acd12]
    client_id = 
    client_secret = 
    token = SECRET_TOKEN
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d>


Configuring by copying the config file

Rclone stores all of its config in a single configuration file. This can
easily be copied to configure a remote rclone.

So first configure rclone on your desktop machine

    rclone config

to set up the config file.

Find the config file by running rclone -h and looking for the help for
the --config option

    $ rclone -h
    [snip]
          --config="/home/user/.rclone.conf": Config file.
    [snip]

Now transfer it to the remote box (scp, cut paste, ftp, sftp etc) and
place it in the correct place (use rclone -h on the remote box to find
out where).



FILTERING, INCLUDES AND EXCLUDES


Rclone has a sophisticated set of include and exclude rules. Some of
these are based on patterns and some on other things like file size.

The filters are applied for the copy, sync, move, ls, lsl, md5sum,
sha1sum, size, delete and check operations. Note that purge does not
obey the filters.

Each path as it passes through rclone is matched against the include and
exclude rules like --include, --exclude, --include-from, --exclude-from,
--filter, or --filter-from. The simplest way to try them out is using
the ls command, or --dry-run together with -v.


Patterns

The patterns used to match files for inclusion or exclusion are based on
"file globs" as used by the unix shell.

If the pattern starts with a / then it only matches at the top level of
the directory tree, RELATIVE TO THE ROOT OF THE REMOTE (not necessarily
the root of the local drive). If it doesn't start with / then it is
matched starting at the END OF THE PATH, but it will only match a
complete path element:

    file.jpg  - matches "file.jpg"
              - matches "directory/file.jpg"
              - doesn't match "afile.jpg"
              - doesn't match "directory/afile.jpg"
    /file.jpg - matches "file.jpg" in the root directory of the remote
              - doesn't match "afile.jpg"
              - doesn't match "directory/file.jpg"

IMPORTANT Note that you must use / in patterns and not \ even if running
on Windows.

A * matches anything but not a /.

    *.jpg  - matches "file.jpg"
           - matches "directory/file.jpg"
           - doesn't match "file.jpg/something"

Use ** to match anything, including slashes (/).

    dir/** - matches "dir/file.jpg"
           - matches "dir/dir1/dir2/file.jpg"
           - doesn't match "directory/file.jpg"
           - doesn't match "adir/file.jpg"

A ? matches any character except a slash /.

    l?ss  - matches "less"
          - matches "lass"
          - doesn't match "floss"

A [ and ] together make a a character class, such as [a-z] or [aeiou] or
[[:alpha:]]. See the go regexp docs for more info on these.

    h[ae]llo - matches "hello"
             - matches "hallo"
             - doesn't match "hullo"

A { and } define a choice between elements. It should contain a comma
seperated list of patterns, any of which might match. These patterns can
contain wildcards.

    {one,two}_potato - matches "one_potato"
                     - matches "two_potato"
                     - doesn't match "three_potato"
                     - doesn't match "_potato"

Special characters can be escaped with a \ before them.

    \*.jpg       - matches "*.jpg"
    \\.jpg       - matches "\.jpg"
    \[one\].jpg  - matches "[one].jpg"

Note also that rclone filter globs can only be used in one of the filter
command line flags, not in the specification of the remote, so
rclone copy "remote:dir*.jpg" /path/to/dir won't work - what is required
is rclone --include "*.jpg" copy remote:dir /path/to/dir

Directories

Rclone keeps track of directories that could match any file patterns.

Eg if you add the include rule

    /a/*.jpg

Rclone will synthesize the directory include rule

    /a/

If you put any rules which end in / then it will only match directories.

Directory matches are ONLY used to optimise directory access patterns -
you must still match the files that you want to match. Directory matches
won't optimise anything on bucket based remotes (eg s3, swift, google
compute storage, b2) which don't have a concept of directory.

Differences between rsync and rclone patterns

Rclone implements bash style {a,b,c} glob matching which rsync doesn't.

Rclone always does a wildcard match so \ must always escape a \.


How the rules are used

Rclone maintains a combined list of include rules and exclude rules.

Each file is matched in order, starting from the top, against the rule
in the list until it finds a match. The file is then included or
excluded according to the rule type.

If the matcher fails to find a match after testing against all the
entries in the list then the path is included.

For example given the following rules, + being include, - being exclude,

    - secret*.jpg
    + *.jpg
    + *.png
    + file2.avi
    - *

This would include

-   file1.jpg
-   file3.png
-   file2.avi

This would exclude

-   secret17.jpg
-   non *.jpg and *.png

A similar process is done on directory entries before recursing into
them. This only works on remotes which have a concept of directory (Eg
local, google drive, onedrive, amazon drive) and not on bucket based
remotes (eg s3, swift, google compute storage, b2).


Adding filtering rules

Filtering rules are added with the following command line flags.

Repeating options

You can repeat the following options to add more than one rule of that
type.

-   --include
-   --include-from
-   --exclude
-   --exclude-from
-   --filter
-   --filter-from

Note that all the options of the same type are processed together in the
order above, regardless of what order they were placed on the command
line.

So all --include options are processed first in the order they appeared
on the command line, then all --include-from options etc.

To mix up the order includes and excludes, the --filter flag can be
used.

--exclude - Exclude files matching pattern

Add a single exclude rule with --exclude.

This flag can be repeated. See above for the order the flags are
processed in.

Eg --exclude *.bak to exclude all bak files from the sync.

--exclude-from - Read exclude patterns from file

Add exclude rules from a file.

This flag can be repeated. See above for the order the flags are
processed in.

Prepare a file like this exclude-file.txt

    # a sample exclude rule file
    *.bak
    file2.jpg

Then use as --exclude-from exclude-file.txt. This will sync all files
except those ending in bak and file2.jpg.

This is useful if you have a lot of rules.

--include - Include files matching pattern

Add a single include rule with --include.

This flag can be repeated. See above for the order the flags are
processed in.

Eg --include *.{png,jpg} to include all png and jpg files in the backup
and no others.

This adds an implicit --exclude * at the very end of the filter list.
This means you can mix --include and --include-from with the other
filters (eg --exclude) but you must include all the files you want in
the include statement. If this doesn't provide enough flexibility then
you must use --filter-from.

--include-from - Read include patterns from file

Add include rules from a file.

This flag can be repeated. See above for the order the flags are
processed in.

Prepare a file like this include-file.txt

    # a sample include rule file
    *.jpg
    *.png
    file2.avi

Then use as --include-from include-file.txt. This will sync all jpg, png
files and file2.avi.

This is useful if you have a lot of rules.

This adds an implicit --exclude * at the very end of the filter list.
This means you can mix --include and --include-from with the other
filters (eg --exclude) but you must include all the files you want in
the include statement. If this doesn't provide enough flexibility then
you must use --filter-from.

--filter - Add a file-filtering rule

This can be used to add a single include or exclude rule. Include rules
start with + and exclude rules start with -. A special rule called ! can
be used to clear the existing rules.

This flag can be repeated. See above for the order the flags are
processed in.

Eg --filter "- *.bak" to exclude all bak files from the sync.

--filter-from - Read filtering patterns from a file

Add include/exclude rules from a file.

This flag can be repeated. See above for the order the flags are
processed in.

Prepare a file like this filter-file.txt

    # a sample filter rule file
    - secret*.jpg
    + *.jpg
    + *.png
    + file2.avi
    - /dir/Trash/**
    + /dir/**
    # exclude everything else
    - *

Then use as --filter-from filter-file.txt. The rules are processed in
the order that they are defined.

This example will include all jpg and png files, exclude any files
matching secret*.jpg and include file2.avi. It will also include
everything in the directory dir at the root of the sync, except
dir/Trash which it will exclude. Everything else will be excluded from
the sync.

--files-from - Read list of source-file names

This reads a list of file names from the file passed in and ONLY these
files are transferred. The filtering rules are ignored completely if you
use this option.

This option can be repeated to read from more than one file. These are
read in the order that they are placed on the command line.

Prepare a file like this files-from.txt

    # comment
    file1.jpg
    file2.jpg

Then use as --files-from files-from.txt. This will only transfer
file1.jpg and file2.jpg providing they exist.

For example, let's say you had a few files you want to back up regularly
with these absolute paths:

    /home/user1/important
    /home/user1/dir/file
    /home/user2/stuff

To copy these you'd find a common subdirectory - in this case /home and
put the remaining files in files-from.txt with or without leading /, eg

    user1/important
    user1/dir/file
    user2/stuff

You could then copy these to a remote like this

    rclone copy --files-from files-from.txt /home remote:backup

The 3 files will arrive in remote:backup with the paths as in the
files-from.txt.

You could of course choose / as the root too in which case your
files-from.txt might look like this.

    /home/user1/important
    /home/user1/dir/file
    /home/user2/stuff

And you would transfer it like this

    rclone copy --files-from files-from.txt / remote:backup

In this case there will be an extra home directory on the remote.

--min-size - Don't transfer any file smaller than this

This option controls the minimum size file which will be transferred.
This defaults to kBytes but a suffix of k, M, or G can be used.

For example --min-size 50k means no files smaller than 50kByte will be
transferred.

--max-size - Don't transfer any file larger than this

This option controls the maximum size file which will be transferred.
This defaults to kBytes but a suffix of k, M, or G can be used.

For example --max-size 1G means no files larger than 1GByte will be
transferred.

--max-age - Don't transfer any file older than this

This option controls the maximum age of files to transfer. Give in
seconds or with a suffix of:

-   ms - Milliseconds
-   s - Seconds
-   m - Minutes
-   h - Hours
-   d - Days
-   w - Weeks
-   M - Months
-   y - Years

For example --max-age 2d means no files older than 2 days will be
transferred.

--min-age - Don't transfer any file younger than this

This option controls the minimum age of files to transfer. Give in
seconds or with a suffix (see --max-age for list of suffixes)

For example --min-age 2d means no files younger than 2 days will be
transferred.

--delete-excluded - Delete files on dest excluded from sync

IMPORTANT this flag is dangerous - use with --dry-run and -v first.

When doing rclone sync this will delete any files which are excluded
from the sync on the destination.

If for example you did a sync from A to B without the --min-size 50k
flag

    rclone sync A: B:

Then you repeated it like this with the --delete-excluded

    rclone --min-size 50k --delete-excluded sync A: B:

This would delete all files on B which are less than 50 kBytes as these
are now excluded from the sync.

Always test first with --dry-run and -v before using this flag.

--dump-filters - dump the filters to the output

This dumps the defined filters to the output as regular expressions.

Useful for debugging.


Quoting shell metacharacters

The examples above may not work verbatim in your shell as they have
shell metacharacters in them (eg *), and may require quoting.

Eg linux, OSX

-   --include \*.jpg
-   --include '*.jpg'
-   --include='*.jpg'

In Windows the expansion is done by the command not the shell so this
should work fine

-   --include *.jpg



OVERVIEW OF CLOUD STORAGE SYSTEMS


Each cloud storage system is slighly different. Rclone attempts to
provide a unified interface to them, but some underlying differences
show through.


Features

Here is an overview of the major features of each cloud storage system.

  Name                               Hash       ModTime   Case Insensitive   Duplicate Files   MIME Type
  ------------------------------ ------------- --------- ------------------ ----------------- -----------
  Amazon Drive                        MD5         No            Yes                No              R
  Amazon S3                           MD5         Yes            No                No             R/W
  Backblaze B2                       SHA1         Yes            No                No             R/W
  Box                                SHA1         Yes           Yes                No              -
  Dropbox                          DBHASH †       Yes           Yes                No              -
  FTP                                  -          No             No                No              -
  Google Cloud Storage                MD5         Yes            No                No             R/W
  Google Drive                        MD5         Yes            No                Yes            R/W
  HTTP                                 -          No             No                No              R
  Hubic                               MD5         Yes            No                No             R/W
  Microsoft Azure Blob Storage        MD5         Yes            No                No             R/W
  Microsoft OneDrive                 SHA1         Yes           Yes                No              R
  Openstack Swift                     MD5         Yes            No                No             R/W
  QingStor                            MD5         No             No                No             R/W
  SFTP                            MD5, SHA1 ‡     Yes         Depends              No              -
  Yandex Disk                         MD5         Yes            No                No             R/W
  The local filesystem                All         Yes         Depends              No              -

Hash

The cloud storage system supports various hash types of the objects. The
hashes are used when transferring data as an integrity check and can be
specifically used with the --checksum flag in syncs and in the check
command.

To use the verify checksums when transferring between cloud storage
systems they must support a common hash type.

† Note that Dropbox supports its own custom hash. This is an SHA256 sum
of all the 4MB block SHA256s.

‡ SFTP supports checksums if the same login has shell access and md5sum
or sha1sum as well as echo are in the remote's PATH.

ModTime

The cloud storage system supports setting modification times on objects.
If it does then this enables a using the modification times as part of
the sync. If not then only the size will be checked by default, though
the MD5SUM can be checked with the --checksum flag.

All cloud storage systems support some kind of date on the object and
these will be set when transferring from the cloud storage system.

Case Insensitive

If a cloud storage systems is case sensitive then it is possible to have
two files which differ only in case, eg file.txt and FILE.txt. If a
cloud storage system is case insensitive then that isn't possible.

This can cause problems when syncing between a case insensitive system
and a case sensitive system. The symptom of this is that no matter how
many times you run the sync it never completes fully.

The local filesystem and SFTP may or may not be case sensitive depending
on OS.

-   Windows - usually case insensitive, though case is preserved
-   OSX - usually case insensitive, though it is possible to format case
    sensitive
-   Linux - usually case sensitive, but there are case insensitive file
    systems (eg FAT formatted USB keys)

Most of the time this doesn't cause any problems as people tend to avoid
files whose name differs only by case even on case sensitive systems.

Duplicate files

If a cloud storage system allows duplicate files then it can have two
objects with the same name.

This confuses rclone greatly when syncing - use the rclone dedupe
command to rename or remove duplicates.

MIME Type

MIME types (also known as media types) classify types of documents using
a simple text classification, eg text/html or application/pdf.

Some cloud storage systems support reading (R) the MIME type of objects
and some support writing (W) the MIME type of objects.

The MIME type can be important if you are serving files directly to HTTP
from the storage system.

If you are copying from a remote which supports reading (R) to a remote
which supports writing (W) then rclone will preserve the MIME types.
Otherwise they will be guessed from the extension, or the remote itself
may assign the MIME type.


Optional Features

All the remotes support a basic set of features, but there are some
optional features supported by some remotes used to make some operations
more efficient.

  Name                            Purge   Copy   Move   DirMove   CleanUp   ListR   StreamUpload
  ------------------------------ ------- ------ ------ --------- --------- ------- --------------
  Amazon Drive                     Yes     No    Yes      Yes     No #575    No          No
  Amazon S3                        No     Yes     No      No        No       Yes        Yes
  Backblaze B2                     No      No     No      No        Yes      Yes        Yes
  Box                              Yes    Yes    Yes      Yes     No #575    No         Yes
  Dropbox                          Yes    Yes    Yes      Yes     No #575    No         Yes
  FTP                              No      No    Yes      Yes       No       No         Yes
  Google Cloud Storage             Yes    Yes     No      No        No       Yes        Yes
  Google Drive                     Yes    Yes    Yes      Yes       Yes      No         Yes
  HTTP                             No      No     No      No        No       No          No
  Hubic                           Yes †   Yes     No      No        No       Yes        Yes
  Microsoft Azure Blob Storage     Yes    Yes     No      No        No       Yes         No
  Microsoft OneDrive               Yes    Yes    Yes    No #197   No #575    No          No
  Openstack Swift                 Yes †   Yes     No      No        No       Yes        Yes
  QingStor                         No     Yes     No      No        No       Yes         No
  SFTP                             No      No    Yes      Yes       No       No         Yes
  Yandex Disk                      Yes     No     No      No        Yes      Yes        Yes
  The local filesystem             Yes     No    Yes      Yes       No       No         Yes

Purge

This deletes a directory quicker than just deleting all the files in the
directory.

† Note Swift and Hubic implement this in order to delete directory
markers but they don't actually have a quicker way of deleting files
other than deleting them individually.

Copy

Used when copying an object to and from the same remote. This known as a
server side copy so you can copy a file without downloading it and
uploading it again. It is used if you use rclone copy or rclone move if
the remote doesn't support Move directly.

If the server doesn't support Copy directly then for copy operations the
file is downloaded then re-uploaded.

Move

Used when moving/renaming an object on the same remote. This is known as
a server side move of a file. This is used in rclone move if the server
doesn't support DirMove.

If the server isn't capable of Move then rclone simulates it with Copy
then delete. If the server doesn't support Copy then rclone will
download the file and re-upload it.

DirMove

This is used to implement rclone move to move a directory if possible.
If it isn't then it will use Move on each file (which falls back to Copy
then download and upload - see Move section).

CleanUp

This is used for emptying the trash for a remote by rclone cleanup.

If the server can't do CleanUp then rclone cleanup will return an error.

ListR

The remote supports a recursive list to list all the contents beneath a
directory quickly. This enables the --fast-list flag to work. See the
rclone docs for more details.

StreamUpload

Some remotes allow files to be uploaded without knowing the file size in
advance. This allows certain operations to work without spooling the
file to local disk first, e.g. rclone rcat.


Amazon Drive

Paths are specified as remote:path

Paths may be as deep as required, eg remote:directory/subdirectory.

The initial setup for Amazon Drive involves getting a token from Amazon
which you need to do in your browser. rclone config walks you through
it.

The configuration process for Amazon Drive may involve using an oauth
proxy. This is used to keep the Amazon credentials out of the source
code. The proxy runs in Google's very secure App Engine environment and
doesn't store any credentials which pass through it.

NB rclone doesn't not currently have its own Amazon Drive credentials
(see the forum for why) so you will either need to have your own
client_id and client_secret with Amazon Drive, or use a a third party
ouath proxy in which case you will need to enter client_id,
client_secret, auth_url and token_url.

Note also if you are not using Amazon's auth_url and token_url, (ie you
filled in something for those) then if setting up on a remote machine
you can only use the copying the config method of configuration -
rclone authorize will not work.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    n/r/c/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / SSH/SFTP Connection
       \ "sftp"
    14 / Yandex Disk
       \ "yandex"
    Storage> 1
    Amazon Application Client Id - required.
    client_id> your client ID goes here
    Amazon Application Client Secret - required.
    client_secret> your client secret goes here
    Auth server URL - leave blank to use Amazon's.
    auth_url> Optional auth URL
    Token server url - leave blank to use Amazon's.
    token_url> Optional token URL
    Remote config
    Make sure your Redirect URL is set to "http://127.0.0.1:53682/" in your custom config.
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    client_id = your client ID goes here
    client_secret = your client secret goes here
    auth_url = Optional auth URL
    token_url = Optional token URL
    token = {"access_token":"xxxxxxxxxxxxxxxxxxxxxxx","token_type":"bearer","refresh_token":"xxxxxxxxxxxxxxxxxx","expiry":"2015-09-06T16:07:39.658438471+01:00"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See the remote setup docs for how to set it up on a machine with no
Internet browser available.

Note that rclone runs a webserver on your local machine to collect the
token as returned from Amazon. This only runs from the moment it opens
your browser to the moment you get back the verification code. This is
on http://127.0.0.1:53682/ and this it may require you to unblock it
temporarily if you are running a host firewall.

Once configured you can then use rclone like this,

List directories in top level of your Amazon Drive

    rclone lsd remote:

List all the files in your Amazon Drive

    rclone ls remote:

To copy a local directory to an Amazon Drive directory called backup

    rclone copy /home/source remote:backup

Modified time and MD5SUMs

Amazon Drive doesn't allow modification times to be changed via the API
so these won't be accurate or used for syncing.

It does store MD5SUMs so for a more accurate sync, you can use the
--checksum flag.

Deleting files

Any files you delete with rclone will end up in the trash. Amazon don't
provide an API to permanently delete files, nor to empty the trash, so
you will have to do that with one of Amazon's apps or via the Amazon
Drive website. As of November 17, 2016, files are automatically deleted
by Amazon from the trash after 30 days.

Using with non .com Amazon accounts

Let's say you usually use amazon.co.uk. When you authenticate with
rclone it will take you to an amazon.com page to log in. Your
amazon.co.uk email and password should work here just fine.

Specific options

Here are the command line options specific to this cloud storage system.

--acd-templink-threshold=SIZE

Files this size or more will be downloaded via their tempLink. This is
to work around a problem with Amazon Drive which blocks downloads of
files bigger than about 10GB. The default for this is 9GB which
shouldn't need to be changed.

To download files above this threshold, rclone requests a tempLink which
downloads the file through a temporary URL directly from the underlying
S3 storage.

--acd-upload-wait-per-gb=TIME

Sometimes Amazon Drive gives an error when a file has been fully
uploaded but the file appears anyway after a little while. This happens
sometimes for files over 1GB in size and nearly every time for files
bigger than 10GB. This parameter controls the time rclone waits for the
file to appear.

The default value for this parameter is 3 minutes per GB, so by default
it will wait 3 minutes for every GB uploaded to see if the file appears.

You can disable this feature by setting it to 0. This may cause conflict
errors as rclone retries the failed upload but the file will most likely
appear correctly eventually.

These values were determined empirically by observing lots of uploads of
big files for a range of file sizes.

Upload with the -v flag to see more info about what rclone is doing in
this situation.

Limitations

Note that Amazon Drive is case insensitive so you can't have a file
called "Hello.doc" and one called "hello.doc".

Amazon Drive has rate limiting so you may notice errors in the sync (429
errors). rclone will automatically retry the sync up to 3 times by
default (see --retries flag) which should hopefully work around this
problem.

Amazon Drive has an internal limit of file sizes that can be uploaded to
the service. This limit is not officially published, but all files
larger than this will fail.

At the time of writing (Jan 2016) is in the area of 50GB per file. This
means that larger files are likely to fail.

Unfortunately there is no way for rclone to see that this failure is
because of file size, so it will retry the operation, as any other
failure. To avoid this problem, use --max-size 50000M option to limit
the maximum size of uploaded files. Note that --max-size does not split
files into segments, it only ignores files over this size.


Amazon S3

Paths are specified as remote:bucket (or remote: for the lsd command.)
You may put subdirectories in too, eg remote:bucket/path/to/dir.

Here is an example of making an s3 configuration. First run

    rclone config

This will guide you through an interactive setup process.

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    n/s> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 2
    Get AWS credentials from runtime (environment variables or EC2 meta data if no env vars). Only applies if access_key_id and secret_access_key is blank.
    Choose a number from below, or type in your own value
     1 / Enter AWS credentials in the next step
       \ "false"
     2 / Get AWS credentials from the environment (env vars or IAM)
       \ "true"
    env_auth> 1
    AWS Access Key ID - leave blank for anonymous access or runtime credentials.
    access_key_id> access_key
    AWS Secret Access Key (password) - leave blank for anonymous access or runtime credentials.
    secret_access_key> secret_key
    Region to connect to.
    Choose a number from below, or type in your own value
       / The default endpoint - a good choice if you are unsure.
     1 | US Region, Northern Virginia or Pacific Northwest.
       | Leave location constraint empty.
       \ "us-east-1"
       / US West (Oregon) Region
     2 | Needs location constraint us-west-2.
       \ "us-west-2"
       / US West (Northern California) Region
     3 | Needs location constraint us-west-1.
       \ "us-west-1"
       / EU (Ireland) Region Region
     4 | Needs location constraint EU or eu-west-1.
       \ "eu-west-1"
       / EU (Frankfurt) Region
     5 | Needs location constraint eu-central-1.
       \ "eu-central-1"
       / Asia Pacific (Singapore) Region
     6 | Needs location constraint ap-southeast-1.
       \ "ap-southeast-1"
       / Asia Pacific (Sydney) Region
     7 | Needs location constraint ap-southeast-2.
       \ "ap-southeast-2"
       / Asia Pacific (Tokyo) Region
     8 | Needs location constraint ap-northeast-1.
       \ "ap-northeast-1"
       / Asia Pacific (Seoul)
     9 | Needs location constraint ap-northeast-2.
       \ "ap-northeast-2"
       / Asia Pacific (Mumbai)
    10 | Needs location constraint ap-south-1.
       \ "ap-south-1"
       / South America (Sao Paulo) Region
    11 | Needs location constraint sa-east-1.
       \ "sa-east-1"
       / If using an S3 clone that only understands v2 signatures
    12 | eg Ceph/Dreamhost
       | set this and make sure you set the endpoint.
       \ "other-v2-signature"
       / If using an S3 clone that understands v4 signatures set this
    13 | and make sure you set the endpoint.
       \ "other-v4-signature"
    region> 1
    Endpoint for S3 API.
    Leave blank if using AWS to use the default endpoint for the region.
    Specify if using an S3 clone such as Ceph.
    endpoint>
    Location constraint - must be set to match the Region. Used when creating buckets only.
    Choose a number from below, or type in your own value
     1 / Empty for US Region, Northern Virginia or Pacific Northwest.
       \ ""
     2 / US West (Oregon) Region.
       \ "us-west-2"
     3 / US West (Northern California) Region.
       \ "us-west-1"
     4 / EU (Ireland) Region.
       \ "eu-west-1"
     5 / EU Region.
       \ "EU"
     6 / Asia Pacific (Singapore) Region.
       \ "ap-southeast-1"
     7 / Asia Pacific (Sydney) Region.
       \ "ap-southeast-2"
     8 / Asia Pacific (Tokyo) Region.
       \ "ap-northeast-1"
     9 / Asia Pacific (Seoul)
       \ "ap-northeast-2"
    10 / Asia Pacific (Mumbai)
       \ "ap-south-1"
    11 / South America (Sao Paulo) Region.
       \ "sa-east-1"
    location_constraint> 1
    Canned ACL used when creating buckets and/or storing objects in S3.
    For more info visit https://docs.aws.amazon.com/AmazonS3/latest/dev/acl-overview.html#canned-acl
    Choose a number from below, or type in your own value
     1 / Owner gets FULL_CONTROL. No one else has access rights (default).
       \ "private"
     2 / Owner gets FULL_CONTROL. The AllUsers group gets READ access.
       \ "public-read"
       / Owner gets FULL_CONTROL. The AllUsers group gets READ and WRITE access.
     3 | Granting this on a bucket is generally not recommended.
       \ "public-read-write"
     4 / Owner gets FULL_CONTROL. The AuthenticatedUsers group gets READ access.
       \ "authenticated-read"
       / Object owner gets FULL_CONTROL. Bucket owner gets READ access.
     5 | If you specify this canned ACL when creating a bucket, Amazon S3 ignores it.
       \ "bucket-owner-read"
       / Both the object owner and the bucket owner get FULL_CONTROL over the object.
     6 | If you specify this canned ACL when creating a bucket, Amazon S3 ignores it.
       \ "bucket-owner-full-control"
    acl> private
    The server-side encryption algorithm used when storing this object in S3.
    Choose a number from below, or type in your own value
     1 / None
       \ ""
     2 / AES256
       \ "AES256"
    server_side_encryption>
    The storage class to use when storing objects in S3.
    Choose a number from below, or type in your own value
     1 / Default
       \ ""
     2 / Standard storage class
       \ "STANDARD"
     3 / Reduced redundancy storage class
       \ "REDUCED_REDUNDANCY"
     4 / Standard Infrequent Access storage class
       \ "STANDARD_IA"
    storage_class>
    Remote config
    --------------------
    [remote]
    env_auth = false
    access_key_id = access_key
    secret_access_key = secret_key
    region = us-east-1
    endpoint =
    location_constraint =
    acl = private
    server_side_encryption =
    storage_class =
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all buckets

    rclone lsd remote:

Make a new bucket

    rclone mkdir remote:bucket

List the contents of a bucket

    rclone ls remote:bucket

Sync /home/local/directory to the remote bucket, deleting any excess
files in the bucket.

    rclone sync /home/local/directory remote:bucket

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

The modified time is stored as metadata on the object as
X-Amz-Meta-Mtime as floating point since the epoch accurate to 1 ns.

Multipart uploads

rclone supports multipart uploads with S3 which means that it can upload
files bigger than 5GB. Note that files uploaded with multipart upload
don't have an MD5SUM.

Buckets and Regions

With Amazon S3 you can list buckets (rclone lsd) using any region, but
you can only access the content of a bucket from the region it was
created in. If you attempt to access a bucket from the wrong region, you
will get an error, incorrect region, the bucket is not in 'XXX' region.

Authentication

There are two ways to supply rclone with a set of AWS credentials. In
order of precedence:

-   Directly in the rclone configuration file (as configured by
    rclone config)
-   set access_key_id and secret_access_key. session_token can be
    optionally set when using AWS STS.
-   Runtime configuration:
-   set env_auth to true in the config file
-   Exporting the following environment variables before running rclone
    -   Access Key ID: AWS_ACCESS_KEY_ID or AWS_ACCESS_KEY
    -   Secret Access Key: AWS_SECRET_ACCESS_KEY or AWS_SECRET_KEY
    -   Session Token: AWS_SESSION_TOKEN
-   Running rclone on an EC2 instance with an IAM role

If none of these option actually end up providing rclone with AWS
credentials then S3 interaction will be non-authenticated (see below).

S3 Permissions

When using the sync subcommand of rclone the following minimum
permissions are required to be available on the bucket being written to:

-   ListBucket
-   DeleteObject
-   GetObject
-   PutObject
-   PutObjectACL

Example policy:

    {
        "Version": "2012-10-17",
        "Statement": [
            {
                "Effect": "Allow",
                "Principal": {
                    "AWS": "arn:aws:iam::USER_SID:user/USER_NAME"
                },
                "Action": [
                    "s3:ListBucket",
                    "s3:DeleteObject",
                    "s3:GetObject",
                    "s3:PutObject",
                    "s3:PutObjectAcl"
                ],
                "Resource": [
                  "arn:aws:s3:::BUCKET_NAME/*",
                  "arn:aws:s3:::BUCKET_NAME"
                ]
            }
        ]
    }

Notes on above:

1.  This is a policy that can be used when creating bucket. It assumes
    that USER_NAME has been created.
2.  The Resource entry must include both resource ARNs, as one implies
    the bucket and the other implies the bucket's objects.

For reference, here's an Ansible script that will generate one or more
buckets that will work with rclone sync.

Glacier

You can transition objects to glacier storage using a lifecycle policy.
The bucket can still be synced or copied into normally, but if rclone
tries to access the data you will see an error like below.

    2017/09/11 19:07:43 Failed to sync: failed to open source object: Object in GLACIER, restore first: path/to/file

In this case you need to restore the object(s) in question before using
rclone.

Specific options

Here are the command line options specific to this cloud storage system.

--s3-acl=STRING

Canned ACL used when creating buckets and/or storing objects in S3.

For more info visit the canned ACL docs.

--s3-storage-class=STRING

Storage class to upload new objects with.

Available options include:

-   STANDARD - default storage class
-   STANDARD_IA - for less frequently accessed data (e.g backups)
-   REDUCED_REDUNDANCY (only for noncritical, reproducible data, has
    lower redundancy)

Anonymous access to public buckets

If you want to use rclone to access a public bucket, configure with a
blank access_key_id and secret_access_key. Eg

    No remotes found - make a new one
    n) New remote
    q) Quit config
    n/q> n
    name> anons3
    What type of source is it?
    Choose a number from below
     1) amazon cloud drive
     2) b2
     3) drive
     4) dropbox
     5) google cloud storage
     6) swift
     7) hubic
     8) local
     9) onedrive
    10) s3
    11) yandex
    type> 10
    Get AWS credentials from runtime (environment variables or EC2 meta data if no env vars). Only applies if access_key_id and secret_access_key is blank.
    Choose a number from below, or type in your own value
     * Enter AWS credentials in the next step
     1) false
     * Get AWS credentials from the environment (env vars or IAM)
     2) true
    env_auth> 1
    AWS Access Key ID - leave blank for anonymous access or runtime credentials.
    access_key_id>
    AWS Secret Access Key (password) - leave blank for anonymous access or runtime credentials.
    secret_access_key>
    ...

Then use it as normal with the name of the public bucket, eg

    rclone lsd anons3:1000genomes

You will be able to list and copy data but not upload it.

Ceph

Ceph is an object storage system which presents an Amazon S3 interface.

To use rclone with ceph, you need to set the following parameters in the
config.

    access_key_id = Whatever
    secret_access_key = Whatever
    endpoint = https://ceph.endpoint.goes.here/
    region = other-v2-signature

Note also that Ceph sometimes puts / in the passwords it gives users. If
you read the secret access key using the command line tools you will get
a JSON blob with the / escaped as \/. Make sure you only write / in the
secret access key.

Eg the dump from Ceph looks something like this (irrelevant keys
removed).

    {
        "user_id": "xxx",
        "display_name": "xxxx",
        "keys": [
            {
                "user": "xxx",
                "access_key": "xxxxxx",
                "secret_key": "xxxxxx\/xxxx"
            }
        ],
    }

Because this is a json dump, it is encoding the / as \/, so if you use
the secret key as xxxxxx/xxxx it will work fine.

Minio

Minio is an object storage server built for cloud application developers
and devops.

It is very easy to install and provides an S3 compatible server which
can be used by rclone.

To use it, install Minio following the instructions here.

When it configures itself Minio will print something like this

    Endpoint:  http://192.168.1.106:9000  http://172.23.0.1:9000
    AccessKey: USWUXHGYZQYFYFFIT3RE
    SecretKey: MOJRH0mkL1IPauahWITSVvyDrQbEEIwljvmxdq03
    Region:    us-east-1
    SQS ARNs:  arn:minio:sqs:us-east-1:1:redis arn:minio:sqs:us-east-1:2:redis

    Browser Access:
       http://192.168.1.106:9000  http://172.23.0.1:9000

    Command-line Access: https://docs.minio.io/docs/minio-client-quickstart-guide
       $ mc config host add myminio http://192.168.1.106:9000 USWUXHGYZQYFYFFIT3RE MOJRH0mkL1IPauahWITSVvyDrQbEEIwljvmxdq03

    Object API (Amazon S3 compatible):
       Go:         https://docs.minio.io/docs/golang-client-quickstart-guide
       Java:       https://docs.minio.io/docs/java-client-quickstart-guide
       Python:     https://docs.minio.io/docs/python-client-quickstart-guide
       JavaScript: https://docs.minio.io/docs/javascript-client-quickstart-guide
       .NET:       https://docs.minio.io/docs/dotnet-client-quickstart-guide

    Drive Capacity: 26 GiB Free, 165 GiB Total

These details need to go into rclone config like this. Note that it is
important to put the region in as stated above.

    env_auth> 1
    access_key_id> USWUXHGYZQYFYFFIT3RE
    secret_access_key> MOJRH0mkL1IPauahWITSVvyDrQbEEIwljvmxdq03
    region> us-east-1
    endpoint> http://192.168.1.106:9000
    location_constraint>
    server_side_encryption>

Which makes the config file look like this

    [minio]
    env_auth = false
    access_key_id = USWUXHGYZQYFYFFIT3RE
    secret_access_key = MOJRH0mkL1IPauahWITSVvyDrQbEEIwljvmxdq03
    region = us-east-1
    endpoint = http://192.168.1.106:9000
    location_constraint =
    server_side_encryption =

So once set up, for example to copy files into a bucket

    rclone copy /path/to/files minio:bucket

Wasabi

Wasabi is a cloud-based object storage service for a broad range of
applications and use cases. Wasabi is designed for individuals and
organizations that require a high-performance, reliable, and secure data
storage infrastructure at minimal cost.

Wasabi provides an S3 interface which can be configured for use with
rclone like this.

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    n/s> n
    name> wasabi
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
    [snip]
    Storage> s3
    Get AWS credentials from runtime (environment variables or EC2 meta data if no env vars). Only applies if access_key_id and secret_access_key is blank.
    Choose a number from below, or type in your own value
     1 / Enter AWS credentials in the next step
       \ "false"
     2 / Get AWS credentials from the environment (env vars or IAM)
       \ "true"
    env_auth> 1
    AWS Access Key ID - leave blank for anonymous access or runtime credentials.
    access_key_id> YOURACCESSKEY
    AWS Secret Access Key (password) - leave blank for anonymous access or runtime credentials.
    secret_access_key> YOURSECRETACCESSKEY
    Region to connect to.
    Choose a number from below, or type in your own value
       / The default endpoint - a good choice if you are unsure.
     1 | US Region, Northern Virginia or Pacific Northwest.
       | Leave location constraint empty.
       \ "us-east-1"
    [snip]
    region> us-east-1
    Endpoint for S3 API.
    Leave blank if using AWS to use the default endpoint for the region.
    Specify if using an S3 clone such as Ceph.
    endpoint> s3.wasabisys.com
    Location constraint - must be set to match the Region. Used when creating buckets only.
    Choose a number from below, or type in your own value
     1 / Empty for US Region, Northern Virginia or Pacific Northwest.
       \ ""
    [snip]
    location_constraint> 
    Canned ACL used when creating buckets and/or storing objects in S3.
    For more info visit https://docs.aws.amazon.com/AmazonS3/latest/dev/acl-overview.html#canned-acl
    Choose a number from below, or type in your own value
     1 / Owner gets FULL_CONTROL. No one else has access rights (default).
       \ "private"
    [snip]
    acl> 
    The server-side encryption algorithm used when storing this object in S3.
    Choose a number from below, or type in your own value
     1 / None
       \ ""
     2 / AES256
       \ "AES256"
    server_side_encryption> 
    The storage class to use when storing objects in S3.
    Choose a number from below, or type in your own value
     1 / Default
       \ ""
     2 / Standard storage class
       \ "STANDARD"
     3 / Reduced redundancy storage class
       \ "REDUCED_REDUNDANCY"
     4 / Standard Infrequent Access storage class
       \ "STANDARD_IA"
    storage_class> 
    Remote config
    --------------------
    [wasabi]
    env_auth = false
    access_key_id = YOURACCESSKEY
    secret_access_key = YOURSECRETACCESSKEY
    region = us-east-1
    endpoint = s3.wasabisys.com
    location_constraint = 
    acl = 
    server_side_encryption = 
    storage_class = 
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This will leave the config file looking like this.

    [wasabi]
    env_auth = false
    access_key_id = YOURACCESSKEY
    secret_access_key = YOURSECRETACCESSKEY
    region = us-east-1
    endpoint = s3.wasabisys.com
    location_constraint = 
    acl = 
    server_side_encryption = 
    storage_class = 


Backblaze B2

B2 is Backblaze's cloud storage system.

Paths are specified as remote:bucket (or remote: for the lsd command.)
You may put subdirectories in too, eg remote:bucket/path/to/dir.

Here is an example of making a b2 configuration. First run

    rclone config

This will guide you through an interactive setup process. You will need
your account number (a short hex number) and key (a long hex number)
which you can get from the b2 control panel.

    No remotes found - make a new one
    n) New remote
    q) Quit config
    n/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 3
    Account ID
    account> 123456789abc
    Application Key
    key> 0123456789abcdef0123456789abcdef0123456789
    Endpoint for the service - leave blank normally.
    endpoint>
    Remote config
    --------------------
    [remote]
    account = 123456789abc
    key = 0123456789abcdef0123456789abcdef0123456789
    endpoint =
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all buckets

    rclone lsd remote:

Make a new bucket

    rclone mkdir remote:bucket

List the contents of a bucket

    rclone ls remote:bucket

Sync /home/local/directory to the remote bucket, deleting any excess
files in the bucket.

    rclone sync /home/local/directory remote:bucket

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

The modified time is stored as metadata on the object as
X-Bz-Info-src_last_modified_millis as milliseconds since 1970-01-01 in
the Backblaze standard. Other tools should be able to use this as a
modified time.

Modified times are used in syncing and are fully supported except in the
case of updating a modification time on an existing object. In this case
the object will be uploaded again as B2 doesn't have an API method to
set the modification time independent of doing an upload.

SHA1 checksums

The SHA1 checksums of the files are checked on upload and download and
will be used in the syncing process.

Large files which are uploaded in chunks will store their SHA1 on the
object as X-Bz-Info-large_file_sha1 as recommended by Backblaze.

Transfers

Backblaze recommends that you do lots of transfers simultaneously for
maximum speed. In tests from my SSD equiped laptop the optimum setting
is about --transfers 32 though higher numbers may be used for a slight
speed improvement. The optimum number for you may vary depending on your
hardware, how big the files are, how much you want to load your
computer, etc. The default of --transfers 4 is definitely too low for
Backblaze B2 though.

Note that uploading big files (bigger than 200 MB by default) will use a
96 MB RAM buffer by default. There can be at most --transfers of these
in use at any moment, so this sets the upper limit on the memory used.

Versions

When rclone uploads a new version of a file it creates a new version of
it. Likewise when you delete a file, the old version will be marked
hidden and still be available. Conversely, you may opt in to a "hard
delete" of files with the --b2-hard-delete flag which would permanently
remove the file instead of hiding it.

Old versions of files, where available, are visible using the
--b2-versions flag.

If you wish to remove all the old versions then you can use the
rclone cleanup remote:bucket command which will delete all the old
versions of files, leaving the current ones intact. You can also supply
a path and only old versions under that path will be deleted, eg
rclone cleanup remote:bucket/path/to/stuff.

When you purge a bucket, the current and the old versions will be
deleted then the bucket will be deleted.

However delete will cause the current versions of the files to become
hidden old versions.

Here is a session showing the listing and and retreival of an old
version followed by a cleanup of the old versions.

Show current version and all the versions with --b2-versions flag.

    $ rclone -q ls b2:cleanup-test
            9 one.txt

    $ rclone -q --b2-versions ls b2:cleanup-test
            9 one.txt
            8 one-v2016-07-04-141032-000.txt
           16 one-v2016-07-04-141003-000.txt
           15 one-v2016-07-02-155621-000.txt

Retreive an old verson

    $ rclone -q --b2-versions copy b2:cleanup-test/one-v2016-07-04-141003-000.txt /tmp

    $ ls -l /tmp/one-v2016-07-04-141003-000.txt
    -rw-rw-r-- 1 ncw ncw 16 Jul  2 17:46 /tmp/one-v2016-07-04-141003-000.txt

Clean up all the old versions and show that they've gone.

    $ rclone -q cleanup b2:cleanup-test

    $ rclone -q ls b2:cleanup-test
            9 one.txt

    $ rclone -q --b2-versions ls b2:cleanup-test
            9 one.txt

Data usage

It is useful to know how many requests are sent to the server in
different scenarios.

All copy commands send the following 4 requests:

    /b2api/v1/b2_authorize_account
    /b2api/v1/b2_create_bucket
    /b2api/v1/b2_list_buckets
    /b2api/v1/b2_list_file_names

The b2_list_file_names request will be sent once for every 1k files in
the remote path, providing the checksum and modification time of the
listed files. As of version 1.33 issue #818 causes extra requests to be
sent when using B2 with Crypt. When a copy operation does not require
any files to be uploaded, no more requests will be sent.

Uploading files that do not require chunking, will send 2 requests per
file upload:

    /b2api/v1/b2_get_upload_url
    /b2api/v1/b2_upload_file/

Uploading files requiring chunking, will send 2 requests (one each to
start and finish the upload) and another 2 requests for each chunk:

    /b2api/v1/b2_start_large_file
    /b2api/v1/b2_get_upload_part_url
    /b2api/v1/b2_upload_part/
    /b2api/v1/b2_finish_large_file

B2 with crypt

When using B2 with crypt files are encrypted into a temporary location
and streamed from there. This is required to calculate the encrypted
file's checksum before beginning the upload. On Windows the %TMPDIR%
environment variable is used as the temporary location. If the file
requires chunking, both the chunking and encryption will take place in
memory.

Specific options

Here are the command line options specific to this cloud storage system.

--b2-chunk-size valuee=SIZE

When uploading large files chunk the file into this size. Note that
these chunks are buffered in memory and there might a maximum of
--transfers chunks in progress at once. 5,000,000 Bytes is the minimim
size (default 96M).

--b2-upload-cutoff=SIZE

Cutoff for switching to chunked upload (default 190.735 MiB == 200 MB).
Files above this size will be uploaded in chunks of --b2-chunk-size.

This value should be set no larger than 4.657GiB (== 5GB) as this is the
largest file size that can be uploaded.

--b2-test-mode=FLAG

This is for debugging purposes only.

Setting FLAG to one of the strings below will cause b2 to return
specific errors for debugging purposes.

-   fail_some_uploads
-   expire_some_account_authorization_tokens
-   force_cap_exceeded

These will be set in the X-Bz-Test-Mode header which is documented in
the b2 integrations checklist.

--b2-versions

When set rclone will show and act on older versions of files. For
example

Listing without --b2-versions

    $ rclone -q ls b2:cleanup-test
            9 one.txt

And with

    $ rclone -q --b2-versions ls b2:cleanup-test
            9 one.txt
            8 one-v2016-07-04-141032-000.txt
           16 one-v2016-07-04-141003-000.txt
           15 one-v2016-07-02-155621-000.txt

Showing that the current version is unchanged but older versions can be
seen. These have the UTC date that they were uploaded to the server to
the nearest millisecond appended to them.

Note that when using --b2-versions no file write operations are
permitted, so you can't upload files or delete them.


Box

Paths are specified as remote:path

Paths may be as deep as required, eg remote:directory/subdirectory.

The initial setup for Box involves getting a token from Box which you
need to do in your browser. rclone config walks you through it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Box
       \ "box"
     5 / Dropbox
       \ "dropbox"
     6 / Encrypt/Decrypt a remote
       \ "crypt"
     7 / FTP Connection
       \ "ftp"
     8 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     9 / Google Drive
       \ "drive"
    10 / Hubic
       \ "hubic"
    11 / Local Disk
       \ "local"
    12 / Microsoft OneDrive
       \ "onedrive"
    13 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    14 / SSH/SFTP Connection
       \ "sftp"
    15 / Yandex Disk
       \ "yandex"
    16 / http Connection
       \ "http"
    Storage> box
    Box App Client Id - leave blank normally.
    client_id> 
    Box App Client Secret - leave blank normally.
    client_secret> 
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    client_id = 
    client_secret = 
    token = {"access_token":"XXX","token_type":"bearer","refresh_token":"XXX","expiry":"XXX"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See the remote setup docs for how to set it up on a machine with no
Internet browser available.

Note that rclone runs a webserver on your local machine to collect the
token as returned from Box. This only runs from the moment it opens your
browser to the moment you get back the verification code. This is on
http://127.0.0.1:53682/ and this it may require you to unblock it
temporarily if you are running a host firewall.

Once configured you can then use rclone like this,

List directories in top level of your Box

    rclone lsd remote:

List all the files in your Box

    rclone ls remote:

To copy a local directory to an Box directory called backup

    rclone copy /home/source remote:backup

Invalid refresh token

According to the box docs:

  Each refresh_token is valid for one use in 60 days.

This means that if you

-   Don't use the box remote for 60 days
-   Copy the config file with a box refresh token in and use it in two
    places
-   Get an error on a token refresh

then rclone will return an error which includes the text
Invalid refresh token.

To fix this you will need to use oauth2 again to update the refresh
token. You can use the methods in the remote setup docs, bearing in mind
that if you use the copy the config file method, you should not use that
remote on the computer you did the authentication on.

Here is how to do it.

    $ rclone config
    Current remotes:

    Name                 Type
    ====                 ====
    remote               box

    e) Edit existing remote
    n) New remote
    d) Delete remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    e/n/d/r/c/s/q> e
    Choose a number from below, or type in an existing value
     1 > remote
    remote> remote
    --------------------
    [remote]
    type = box
    token = {"access_token":"XXX","token_type":"bearer","refresh_token":"XXX","expiry":"2017-07-08T23:40:08.059167677+01:00"}
    --------------------
    Edit remote
    Value "client_id" = ""
    Edit? (y/n)>
    y) Yes
    n) No
    y/n> n
    Value "client_secret" = ""
    Edit? (y/n)>
    y) Yes
    n) No
    y/n> n
    Remote config
    Already have a token - refresh?
    y) Yes
    n) No
    y/n> y
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    type = box
    token = {"access_token":"YYY","token_type":"bearer","refresh_token":"YYY","expiry":"2017-07-23T12:22:29.259137901+01:00"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

Modified time and hashes

Box allows modification times to be set on objects accurate to 1 second.
These will be used to detect whether objects need syncing or not.

One drive supports SHA1 type hashes, so you can use the --checksum flag.

Transfers

For files above 50MB rclone will use a chunked transfer. Rclone will
upload up to --transfers chunks at the same time (shared among all the
multipart uploads). Chunks are buffered in memory and are normally 8MB
so increasing --transfers will increase memory use.

Deleting files

Depending on the enterprise settings for your user, the item will either
be actually deleted from Box or moved to the trash.

Specific options

Here are the command line options specific to this cloud storage system.

--box-upload-cutoff=SIZE

Cutoff for switching to chunked upload - must be >= 50MB. The default is
50MB.

Limitations

Note that Box is case insensitive so you can't have a file called
"Hello.doc" and one called "hello.doc".

Box file names can't have the \ character in. rclone maps this to and
from an identical looking unicode equivalent ＼.

Box only supports filenames up to 255 characters in length.


Crypt

The crypt remote encrypts and decrypts another remote.

To use it first set up the underlying remote following the config
instructions for that remote. You can also use a local pathname instead
of a remote which will encrypt and decrypt from that directory which
might be useful for encrypting onto a USB stick for example.

First check your chosen remote is working - we'll call it remote:path in
these docs. Note that anything inside remote:path will be encrypted and
anything outside won't. This means that if you are using a bucket based
remote (eg S3, B2, swift) then you should probably put the bucket in the
remote s3:bucket. If you just use s3: then rclone will make encrypted
bucket names too (if using file name encryption) which may or may not be
what you want.

Now configure crypt using rclone config. We will call this one secret to
differentiate it from the remote.

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n   
    name> secret
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 5
    Remote to encrypt/decrypt.
    Normally should contain a ':' and a path, eg "myremote:path/to/dir",
    "myremote:bucket" or maybe "myremote:" (not recommended).
    remote> remote:path
    How to encrypt the filenames.
    Choose a number from below, or type in your own value
     1 / Don't encrypt the file names.  Adds a ".bin" extension only.
       \ "off"
     2 / Encrypt the filenames see the docs for the details.
       \ "standard"
     3 / Very simple filename obfuscation.
       \ "obfuscate"
    filename_encryption> 2
    Password or pass phrase for encryption.
    y) Yes type in my own password
    g) Generate random password
    y/g> y
    Enter the password:
    password:
    Confirm the password:
    password:
    Password or pass phrase for salt. Optional but recommended.
    Should be different to the previous password.
    y) Yes type in my own password
    g) Generate random password
    n) No leave this optional password blank
    y/g/n> g
    Password strength in bits.
    64 is just about memorable
    128 is secure
    1024 is the maximum
    Bits> 128
    Your password is: JAsJvRcgR-_veXNfy_sGmQ
    Use this password?
    y) Yes
    n) No
    y/n> y
    Remote config
    --------------------
    [secret]
    remote = remote:path
    filename_encryption = standard
    password = *** ENCRYPTED ***
    password2 = *** ENCRYPTED ***
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

IMPORTANT The password is stored in the config file is lightly obscured
so it isn't immediately obvious what it is. It is in no way secure
unless you use config file encryption.

A long passphrase is recommended, or you can use a random one. Note that
if you reconfigure rclone with the same passwords/passphrases elsewhere
it will be compatible - all the secrets used are derived from those two
passwords/passphrases.

Note that rclone does not encrypt

-   file length - this can be calcuated within 16 bytes
-   modification time - used for syncing


Specifying the remote

In normal use, make sure the remote has a : in. If you specify the
remote without a : then rclone will use a local directory of that name.
So if you use a remote of /path/to/secret/files then rclone will encrypt
stuff to that directory. If you use a remote of name then rclone will
put files in a directory called name in the current directory.

If you specify the remote as remote:path/to/dir then rclone will store
encrypted files in path/to/dir on the remote. If you are using file name
encryption, then when you save files to secret:subdir/subfile this will
store them in the unencrypted path path/to/dir but the subdir/subpath
bit will be encrypted.

Note that unless you want encrypted bucket names (which are difficult to
manage because you won't know what directory they represent in web
interfaces etc), you should probably specify a bucket, eg
remote:secretbucket when using bucket based remotes such as S3, Swift,
Hubic, B2, GCS.


Example

To test I made a little directory of files using "standard" file name
encryption.

    plaintext/
    ├── file0.txt
    ├── file1.txt
    └── subdir
        ├── file2.txt
        ├── file3.txt
        └── subsubdir
            └── file4.txt

Copy these to the remote and list them back

    $ rclone -q copy plaintext secret:
    $ rclone -q ls secret:
            7 file1.txt
            6 file0.txt
            8 subdir/file2.txt
           10 subdir/subsubdir/file4.txt
            9 subdir/file3.txt

Now see what that looked like when encrypted

    $ rclone -q ls remote:path
           55 hagjclgavj2mbiqm6u6cnjjqcg
           54 v05749mltvv1tf4onltun46gls
           57 86vhrsv86mpbtd3a0akjuqslj8/dlj7fkq4kdq72emafg7a7s41uo
           58 86vhrsv86mpbtd3a0akjuqslj8/7uu829995du6o42n32otfhjqp4/b9pausrfansjth5ob3jkdqd4lc
           56 86vhrsv86mpbtd3a0akjuqslj8/8njh1sk437gttmep3p70g81aps

Note that this retains the directory structure which means you can do
this

    $ rclone -q ls secret:subdir
            8 file2.txt
            9 file3.txt
           10 subsubdir/file4.txt

If don't use file name encryption then the remote will look like this -
note the .bin extensions added to prevent the cloud provider attempting
to interpret the data.

    $ rclone -q ls remote:path
           54 file0.txt.bin
           57 subdir/file3.txt.bin
           56 subdir/file2.txt.bin
           58 subdir/subsubdir/file4.txt.bin
           55 file1.txt.bin

File name encryption modes

Here are some of the features of the file name encryption modes

Off

-   doesn't hide file names or directory structure
-   allows for longer file names (~246 characters)
-   can use sub paths and copy single files

Standard

-   file names encrypted
-   file names can't be as long (~156 characters)
-   can use sub paths and copy single files
-   directory structure visibile
-   identical files names will have identical uploaded names
-   can use shortcuts to shorten the directory recursion

Obfuscation

This is a simple "rotate" of the filename, with each file having a rot
distance based on the filename. We store the distance at the beginning
of the filename. So a file called "hello" may become "53.jgnnq"

This is not a strong encryption of filenames, but it may stop automated
scanning tools from picking up on filename patterns. As such it's an
intermediate between "off" and "standard". The advantage is that it
allows for longer path segment names.

There is a possibility with some unicode based filenames that the
obfuscation is weak and may map lower case characters to upper case
equivalents. You can not rely on this for strong protection.

-   file names very lightly obfuscated
-   file names can be longer than standard encryption
-   can use sub paths and copy single files
-   directory structure visibile
-   identical files names will have identical uploaded names

Cloud storage systems have various limits on file name length and total
path length which you are more likely to hit using "Standard" file name
encryption. If you keep your file names to below 156 characters in
length then you should be OK on all providers.

There may be an even more secure file name encryption mode in the future
which will address the long file name problem.

Modified time and hashes

Crypt stores modification times using the underlying remote so support
depends on that.

Hashes are not stored for crypt. However the data integrity is protected
by an extremely strong crypto authenticator.

Note that you should use the rclone cryptcheck command to check the
integrity of a crypted remote instead of rclone check which can't check
the checksums properly.

Specific options

Here are the command line options specific to this cloud storage system.

--crypt-show-mapping

If this flag is set then for each file that the remote is asked to list,
it will log (at level INFO) a line stating the decrypted file name and
the encrypted file name.

This is so you can work out which encrypted names are which decrypted
names just in case you need to do something with the encrypted file
names, or for debugging purposes.


Backing up a crypted remote

If you wish to backup a crypted remote, it it recommended that you use
rclone sync on the encrypted files, and make sure the passwords are the
same in the new encrypted remote.

This will have the following advantages

-   rclone sync will check the checksums while copying
-   you can use rclone check between the encrypted remotes
-   you don't decrypt and encrypt unecessarily

For example, let's say you have your original remote at remote: with the
encrypted version at eremote: with path remote:crypt. You would then set
up the new remote remote2: and then the encrypted version eremote2: with
path remote2:crypt using the same passwords as eremote:.

To sync the two remotes you would do

    rclone sync remote:crypt remote2:crypt

And to check the integrity you would do

    rclone check remote:crypt remote2:crypt


File formats

File encryption

Files are encrypted 1:1 source file to destination object. The file has
a header and is divided into chunks.

Header

-   8 bytes magic string RCLONE\x00\x00
-   24 bytes Nonce (IV)

The initial nonce is generated from the operating systems crypto strong
random number genrator. The nonce is incremented for each chunk read
making sure each nonce is unique for each block written. The chance of a
nonce being re-used is miniscule. If you wrote an exabyte of data (10¹⁸
bytes) you would have a probability of approximately 2×10⁻³² of re-using
a nonce.

Chunk

Each chunk will contain 64kB of data, except for the last one which may
have less data. The data chunk is in standard NACL secretbox format.
Secretbox uses XSalsa20 and Poly1305 to encrypt and authenticate
messages.

Each chunk contains:

-   16 Bytes of Poly1305 authenticator
-   1 - 65536 bytes XSalsa20 encrypted data

64k chunk size was chosen as the best performing chunk size (the
authenticator takes too much time below this and the performance drops
off due to cache effects above this). Note that these chunks are
buffered in memory so they can't be too big.

This uses a 32 byte (256 bit key) key derived from the user password.

Examples

1 byte file will encrypt to

-   32 bytes header
-   17 bytes data chunk

49 bytes total

1MB (1048576 bytes) file will encrypt to

-   32 bytes header
-   16 chunks of 65568 bytes

1049120 bytes total (a 0.05% overhead). This is the overhead for big
files.

Name encryption

File names are encrypted segment by segment - the path is broken up into
/ separated strings and these are encrypted individually.

File segments are padded using using PKCS#7 to a multiple of 16 bytes
before encryption.

They are then encrypted with EME using AES with 256 bit key. EME
(ECB-Mix-ECB) is a wide-block encryption mode presented in the 2003
paper "A Parallelizable Enciphering Mode" by Halevi and Rogaway.

This makes for determinstic encryption which is what we want - the same
filename must encrypt to the same thing otherwise we can't find it on
the cloud storage system.

This means that

-   filenames with the same name will encrypt the same
-   filenames which start the same won't have a common prefix

This uses a 32 byte key (256 bits) and a 16 byte (128 bits) IV both of
which are derived from the user password.

After encryption they are written out using a modified version of
standard base32 encoding as described in RFC4648. The standard encoding
is modified in two ways:

-   it becomes lower case (no-one likes upper case filenames!)
-   we strip the padding character =

base32 is used rather than the more efficient base64 so rclone can be
used on case insensitive remotes (eg Windows, Amazon Drive).

Key derivation

Rclone uses scrypt with parameters N=16384, r=8, p=1 with a an optional
user supplied salt (password2) to derive the 32+32+16 = 80 bytes of key
material required. If the user doesn't supply a salt then rclone uses an
internal one.

scrypt makes it impractical to mount a dictionary attack on rclone
encrypted data. For full protection agains this you should always use a
salt.


Dropbox

Paths are specified as remote:path

Dropbox paths may be as deep as required, eg
remote:directory/subdirectory.

The initial setup for dropbox involves getting a token from Dropbox
which you need to do in your browser. rclone config walks you through
it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    n) New remote
    d) Delete remote
    q) Quit config
    e/n/d/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 4
    Dropbox App Key - leave blank normally.
    app_key>
    Dropbox App Secret - leave blank normally.
    app_secret>
    Remote config
    Please visit:
    https://www.dropbox.com/1/oauth2/authorize?client_id=XXXXXXXXXXXXXXX&response_type=code
    Enter the code: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX_XXXXXXXXXX
    --------------------
    [remote]
    app_key =
    app_secret =
    token = XXXXXXXXXXXXXXXXXXXXXXXXXXXXX_XXXX_XXXXXXXXXXXXXXXXXXXXXXXXXXXXX
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

You can then use it like this,

List directories in top level of your dropbox

    rclone lsd remote:

List all the files in your dropbox

    rclone ls remote:

To copy a local directory to a dropbox directory called backup

    rclone copy /home/source remote:backup

Modified time and Hashes

Dropbox supports modified times, but the only way to set a modification
time is to re-upload the file.

This means that if you uploaded your data with an older version of
rclone which didn't support the v2 API and modified times, rclone will
decide to upload all your old data to fix the modification times. If you
don't want this to happen use --size-only or --checksum flag to stop it.

Dropbox supports its own hash type which is checked for all transfers.

Specific options

Here are the command line options specific to this cloud storage system.

--dropbox-chunk-size=SIZE

Upload chunk size. Max 150M. The default is 128MB. Note that this isn't
buffered into memory.

Limitations

Note that Dropbox is case insensitive so you can't have a file called
"Hello.doc" and one called "hello.doc".

There are some file names such as thumbs.db which Dropbox can't store.
There is a full list of them in the "Ignored Files" section of this
document. Rclone will issue an error message
File name disallowed - not uploading if it attempt to upload one of
those file names, but the sync won't fail.

If you have more than 10,000 files in a directory then
rclone purge dropbox:dir will return the error
Failed to purge: There are too many files involved in this operation. As
a work-around do an rclone delete dropbox:dir followed by an
rclone rmdir dropbox:dir.


FTP

FTP is the File Transfer Protocol. FTP support is provided using the
github.com/jlaffaye/ftp package.

Here is an example of making an FTP configuration. First run

    rclone config

This will guide you through an interactive setup process. An FTP remote
only needs a host together with and a username and a password. With
anonymous FTP server, you will need to use anonymous as username and
your email address as the password.

    No remotes found - make a new one
    n) New remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    n/r/c/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection 
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / SSH/SFTP Connection
       \ "sftp"
    14 / Yandex Disk
       \ "yandex"
    Storage> ftp
    FTP host to connect to
    Choose a number from below, or type in your own value
     1 / Connect to ftp.example.com
       \ "ftp.example.com"
    host> ftp.example.com
    FTP username, leave blank for current username, ncw
    user>
    FTP port, leave blank to use default (21)
    port>
    FTP password
    y) Yes type in my own password
    g) Generate random password
    y/g> y
    Enter the password:
    password:
    Confirm the password:
    password:
    Remote config
    --------------------
    [remote]
    host = ftp.example.com
    user = 
    port =
    pass = *** ENCRYPTED ***
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all directories in the home directory

    rclone lsd remote:

Make a new directory

    rclone mkdir remote:path/to/directory

List the contents of a directory

    rclone ls remote:path/to/directory

Sync /home/local/directory to the remote directory, deleting any excess
files in the directory.

    rclone sync /home/local/directory remote:directory

Modified time

FTP does not support modified times. Any times you see on the server
will be time of upload.

Checksums

FTP does not support any checksums.

Limitations

Note that since FTP isn't HTTP based the following flags don't work with
it: --dump-headers, --dump-bodies, --dump-auth

Note that --timeout isn't supported (but --contimeout is).

Note that --bind isn't supported.

FTP could support server side move but doesn't yet.


Google Cloud Storage

Paths are specified as remote:bucket (or remote: for the lsd command.)
You may put subdirectories in too, eg remote:bucket/path/to/dir.

The initial setup for google cloud storage involves getting a token from
Google Cloud Storage which you need to do in your browser. rclone config
walks you through it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    n) New remote
    d) Delete remote
    q) Quit config
    e/n/d/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 6
    Google Application Client Id - leave blank normally.
    client_id>
    Google Application Client Secret - leave blank normally.
    client_secret>
    Project number optional - needed only for list/create/delete buckets - see your developer console.
    project_number> 12345678
    Service Account Credentials JSON file path - needed only if you want use SA instead of interactive login.
    service_account_file>
    Access Control List for new objects.
    Choose a number from below, or type in your own value
     1 / Object owner gets OWNER access, and all Authenticated Users get READER access.
       \ "authenticatedRead"
     2 / Object owner gets OWNER access, and project team owners get OWNER access.
       \ "bucketOwnerFullControl"
     3 / Object owner gets OWNER access, and project team owners get READER access.
       \ "bucketOwnerRead"
     4 / Object owner gets OWNER access [default if left blank].
       \ "private"
     5 / Object owner gets OWNER access, and project team members get access according to their roles.
       \ "projectPrivate"
     6 / Object owner gets OWNER access, and all Users get READER access.
       \ "publicRead"
    object_acl> 4
    Access Control List for new buckets.
    Choose a number from below, or type in your own value
     1 / Project team owners get OWNER access, and all Authenticated Users get READER access.
       \ "authenticatedRead"
     2 / Project team owners get OWNER access [default if left blank].
       \ "private"
     3 / Project team members get access according to their roles.
       \ "projectPrivate"
     4 / Project team owners get OWNER access, and all Users get READER access.
       \ "publicRead"
     5 / Project team owners get OWNER access, and all Users get WRITER access.
       \ "publicReadWrite"
    bucket_acl> 2
    Location for the newly created buckets.
    Choose a number from below, or type in your own value
     1 / Empty for default location (US).
       \ ""
     2 / Multi-regional location for Asia.
       \ "asia"
     3 / Multi-regional location for Europe.
       \ "eu"
     4 / Multi-regional location for United States.
       \ "us"
     5 / Taiwan.
       \ "asia-east1"
     6 / Tokyo.
       \ "asia-northeast1"
     7 / Singapore.
       \ "asia-southeast1"
     8 / Sydney.
       \ "australia-southeast1"
     9 / Belgium.
       \ "europe-west1"
    10 / London.
       \ "europe-west2"
    11 / Iowa.
       \ "us-central1"
    12 / South Carolina.
       \ "us-east1"
    13 / Northern Virginia.
       \ "us-east4"
    14 / Oregon.
       \ "us-west1"
    location> 12
    The storage class to use when storing objects in Google Cloud Storage.
    Choose a number from below, or type in your own value
     1 / Default
       \ ""
     2 / Multi-regional storage class
       \ "MULTI_REGIONAL"
     3 / Regional storage class
       \ "REGIONAL"
     4 / Nearline storage class
       \ "NEARLINE"
     5 / Coldline storage class
       \ "COLDLINE"
     6 / Durable reduced availability storage class
       \ "DURABLE_REDUCED_AVAILABILITY"
    storage_class> 5
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine or Y didn't work
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    type = google cloud storage
    client_id =
    client_secret =
    token = {"AccessToken":"xxxx.xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx","RefreshToken":"x/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx_xxxxxxxxx","Expiry":"2014-07-17T20:49:14.929208288+01:00","Extra":null}
    project_number = 12345678
    object_acl = private
    bucket_acl = private
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

Note that rclone runs a webserver on your local machine to collect the
token as returned from Google if you use auto config mode. This only
runs from the moment it opens your browser to the moment you get back
the verification code. This is on http://127.0.0.1:53682/ and this it
may require you to unblock it temporarily if you are running a host
firewall, or use manual mode.

This remote is called remote and can now be used like this

See all the buckets in your project

    rclone lsd remote:

Make a new bucket

    rclone mkdir remote:bucket

List the contents of a bucket

    rclone ls remote:bucket

Sync /home/local/directory to the remote bucket, deleting any excess
files in the bucket.

    rclone sync /home/local/directory remote:bucket

Service Account support

You can set up rclone with Google Cloud Storage in an unattended mode,
i.e. not tied to a specific end-user Google account. This is useful when
you want to synchronise files onto machines that don't have actively
logged-in users, for example build machines.

To get credentials for Google Cloud Platform IAM Service Accounts,
please head to the Service Account section of the Google Developer
Console. Service Accounts behave just like normal User permissions in
Google Cloud Storage ACLs, so you can limit their access (e.g. make them
read only). After creating an account, a JSON file containing the
Service Account's credentials will be downloaded onto your machines.
These credentials are what rclone will use for authentication.

To use a Service Account instead of OAuth2 token flow, enter the path to
your Service Account credentials at the service_account_file prompt and
rclone won't use the browser based authentication flow.

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

Google google cloud storage stores md5sums natively and rclone stores
modification times as metadata on the object, under the "mtime" key in
RFC3339 format accurate to 1ns.


Google Drive

Paths are specified as drive:path

Drive paths may be as deep as required, eg drive:directory/subdirectory.

The initial setup for drive involves getting a token from Google drive
which you need to do in your browser. rclone config walks you through
it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    n/r/c/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / SSH/SFTP Connection
       \ "sftp"
    14 / Yandex Disk
       \ "yandex"
    Storage> 8
    Google Application Client Id - leave blank normally.
    client_id>
    Google Application Client Secret - leave blank normally.
    client_secret>
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine or Y didn't work
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    Configure this as a team drive?
    y) Yes
    n) No
    y/n> n
    --------------------
    [remote]
    client_id =
    client_secret =
    token = {"AccessToken":"xxxx.x.xxxxx_xxxxxxxxxxx_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx","RefreshToken":"1/xxxxxxxxxxxxxxxx_xxxxxxxxxxxxxxxxxxxxxxxxxx","Expiry":"2014-03-16T13:57:58.955387075Z","Extra":null}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

Note that rclone runs a webserver on your local machine to collect the
token as returned from Google if you use auto config mode. This only
runs from the moment it opens your browser to the moment you get back
the verification code. This is on http://127.0.0.1:53682/ and this it
may require you to unblock it temporarily if you are running a host
firewall, or use manual mode.

You can then use it like this,

List directories in top level of your drive

    rclone lsd remote:

List all the files in your drive

    rclone ls remote:

To copy a local directory to a drive directory called backup

    rclone copy /home/source remote:backup

Team drives

If you want to configure the remote to point to a Google Team Drive then
answer y to the question Configure this as a team drive?.

This will fetch the list of Team Drives from google and allow you to
configure which one you want to use. You can also type in a team drive
ID if you prefer.

For example:

    Configure this as a team drive?
    y) Yes
    n) No
    y/n> y
    Fetching team drive list...
    Choose a number from below, or type in your own value
     1 / Rclone Test
       \ "xxxxxxxxxxxxxxxxxxxx"
     2 / Rclone Test 2
       \ "yyyyyyyyyyyyyyyyyyyy"
     3 / Rclone Test 3
       \ "zzzzzzzzzzzzzzzzzzzz"
    Enter a Team Drive ID> 1
    --------------------
    [remote]
    client_id =
    client_secret =
    token = {"AccessToken":"xxxx.x.xxxxx_xxxxxxxxxxx_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx","RefreshToken":"1/xxxxxxxxxxxxxxxx_xxxxxxxxxxxxxxxxxxxxxxxxxx","Expiry":"2014-03-16T13:57:58.955387075Z","Extra":null}
    team_drive = xxxxxxxxxxxxxxxxxxxx
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

Modified time

Google drive stores modification times accurate to 1 ms.

Revisions

Google drive stores revisions of files. When you upload a change to an
existing file to google drive using rclone it will create a new revision
of that file.

Revisions follow the standard google policy which at time of writing was

-   They are deleted after 30 days or 100 revisions (whatever
    comes first).
-   They do not count towards a user storage quota.

Deleting files

By default rclone will send all files to the trash when deleting files.
If deleting them permanently is required then use the
--drive-use-trash=false flag, or set the equivalent environment
variable.

Emptying trash

If you wish to empty your trash you can use the rclone cleanup remote:
command which will permanently delete all your trashed files. This
command does not take any path arguments.

Specific options

Here are the command line options specific to this cloud storage system.

--drive-auth-owner-only

Only consider files owned by the authenticated user.

--drive-chunk-size=SIZE

Upload chunk size. Must a power of 2 >= 256k. Default value is 8 MB.

Making this larger will improve performance, but note that each chunk is
buffered in memory one per transfer.

Reducing this will reduce memory usage but decrease performance.

--drive-formats

Google documents can only be exported from Google drive. When rclone
downloads a Google doc it chooses a format to download depending upon
this setting.

By default the formats are docx,xlsx,pptx,svg which are a sensible
default for an editable document.

When choosing a format, rclone runs down the list provided in order and
chooses the first file format the doc can be exported as from the list.
If the file can't be exported to a format on the formats list, then
rclone will choose a format from the default list.

If you prefer an archive copy then you might use --drive-formats pdf, or
if you prefer openoffice/libreoffice formats you might use
--drive-formats ods,odt,odp.

Note that rclone adds the extension to the google doc, so if it is
calles My Spreadsheet on google docs, it will be exported as
My Spreadsheet.xlsx or My Spreadsheet.pdf etc.

Here are the possible extensions with their corresponding mime types.

  -------------------------------------
  Extension  Mime Type    Description
  ---------- ------------ -------------
  csv        text/csv     Standard CSV
                          format for
                          Spreadsheets

  doc        application/ Micosoft
             msword       Office
                          Document

  docx       application/ Microsoft
             vnd.openxmlf Office
             ormats-offic Document
             edocument.wo 
             rdprocessing 
             ml.document  

  epub       application/ E-book format
             epub+zip     

  html       text/html    An HTML
                          Document

  jpg        image/jpeg   A JPEG Image
                          File

  odp        application/ Openoffice
             vnd.oasis.op Presentation
             endocument.p 
             resentation  

  ods        application/ Openoffice
             vnd.oasis.op Spreadsheet
             endocument.s 
             preadsheet   

  ods        application/ Openoffice
             x-vnd.oasis. Spreadsheet
             opendocument 
             .spreadsheet 

  odt        application/ Openoffice
             vnd.oasis.op Document
             endocument.t 
             ext          

  pdf        application/ Adobe PDF
             pdf          Format

  png        image/png    PNG Image
                          Format

  pptx       application/ Microsoft
             vnd.openxmlf Office
             ormats-offic Powerpoint
             edocument.pr 
             esentationml 
             .presentatio 
             n            

  rtf        application/ Rich Text
             rtf          Format

  svg        image/svg+xm Scalable
             l            Vector
                          Graphics
                          Format

  tsv        text/tab-sep Standard TSV
             arated-value format for
             s            spreadsheets

  txt        text/plain   Plain Text

  xls        application/ Microsoft
             vnd.ms-excel Office
                          Spreadsheet

  xlsx       application/ Microsoft
             vnd.openxmlf Office
             ormats-offic Spreadsheet
             edocument.sp 
             readsheetml. 
             sheet        

  zip        application/ A ZIP file of
             zip          HTML, Images
                          CSS
  -------------------------------------

--drive-list-chunk int

Size of listing chunk 100-1000. 0 to disable. (default 1000)

--drive-shared-with-me

Only show files that are shared with me

--drive-skip-gdocs

Skip google documents in all listings. If given, gdocs practically
become invisible to rclone.

--drive-trashed-only

Only show files that are in the trash. This will show trashed files in
their original directory structure.

--drive-upload-cutoff=SIZE

File size cutoff for switching to chunked upload. Default is 8 MB.

--drive-use-trash

Controls whether files are sent to the trash or deleted permanently.
Defaults to true, namely sending files to the trash. Use
--drive-use-trash=false to delete files permanently instead.

Limitations

Drive has quite a lot of rate limiting. This causes rclone to be limited
to transferring about 2 files per second only. Individual files may be
transferred much faster at 100s of MBytes/s but lots of small files can
take a long time.

Server side copies are also subject to a separate rate limit. If you see
User rate limit exceeded errors, wait at least 24 hours and retry. You
can disable server side copies with --disable copy to download and
upload the files if you prefer.

Duplicated files

Sometimes, for no reason I've been able to track down, drive will
duplicate a file that rclone uploads. Drive unlike all the other remotes
can have duplicated files.

Duplicated files cause problems with the syncing and you will see
messages in the log about duplicates.

Use rclone dedupe to fix duplicated files.

Note that this isn't just a problem with rclone, even Google Photos on
Android duplicates files on drive sometimes.

Rclone appears to be re-copying files it shouldn't

There are two possible reasons for rclone to recopy files which haven't
changed to Google Drive.

The first is the duplicated file issue above - run rclone dedupe and
check your logs for duplicate object or directory messages.

The second is that sometimes Google reports different sizes for the
Google Docs exports which will cause rclone to re-download Google Docs
for no apparent reason. --ignore-size is a not very satisfactory
work-around for this if it is causing you a lot of problems.

Google docs downloads sometimes fail with "Failed to copy: read X bytes expecting Y"

This is the same problem as above. Google reports the google doc is one
size, but rclone downloads a different size. Work-around with the
--ignore-size flag or wait for rclone to retry the download which it
will.

Making your own client_id

When you use rclone with Google drive in its default configuration you
are using rclone's client_id. This is shared between all the rclone
users. There is a global rate limit on the number of queries per second
that each client_id can do set by Google. rclone already has a high
quota and I will continue to make sure it is high enough by contacting
Google.

However you might find you get better performance making your own
client_id if you are a heavy user. Or you may not depending on exactly
how Google have been raising rclone's rate limit.

Here is how to create your own Google Drive client ID for rclone:

1.  Log into the Google API Console with your Google account. It doesn't
    matter what Google account you use. (It need not be the same account
    as the Google Drive you want to access)

2.  Select a project or create a new project.

3.  Under Overview, Google APIs, Google Apps APIs, click "Drive API",
    then "Enable".

4.  Click "Credentials" in the left-side panel (not "Go to credentials",
    which opens the wizard), then "Create credentials", then "OAuth
    client ID". It will prompt you to set the OAuth consent screen
    product name, if you haven't set one already.

5.  Choose an application type of "other", and click "Create". (the
    default name is fine)

6.  It will show you a client ID and client secret. Use these values in
    rclone config to add a new remote or edit an existing remote.

(Thanks to @balazer on github for these instructions.)


HTTP

The HTTP remote is a read only remote for reading files of a webserver.
The webserver should provide file listings which rclone will read and
turn into a remote. This has been tested with common webservers such as
Apache/Nginx/Caddy and will likely work with file listings from most web
servers. (If it doesn't then please file an issue, or send a pull
request!)

Paths are specified as remote: or remote:path/to/dir.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / SSH/SFTP Connection
       \ "sftp"
    14 / Yandex Disk
       \ "yandex"
    15 / http Connection
       \ "http"
    Storage> http
    URL of http host to connect to
    Choose a number from below, or type in your own value
     1 / Connect to example.com
       \ "https://example.com"
    url> https://beta.rclone.org
    Remote config
    --------------------
    [remote]
    url = https://beta.rclone.org
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y
    Current remotes:

    Name                 Type
    ====                 ====
    remote               http

    e) Edit existing remote
    n) New remote
    d) Delete remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    e/n/d/r/c/s/q> q

This remote is called remote and can now be used like this

See all the top level directories

    rclone lsd remote:

List the contents of a directory

    rclone ls remote:directory

Sync the remote directory to /home/local/directory, deleting any excess
files.

    rclone sync remote:directory /home/local/directory

Read only

This remote is read only - you can't upload files to an HTTP server.

Modified time

Most HTTP servers store time accurate to 1 second.

Checksum

No checksums are stored.

Usage without a config file

Note that since only two environment variable need to be set, it is easy
to use without a config file like this.

    RCLONE_CONFIG_ZZ_TYPE=http RCLONE_CONFIG_ZZ_URL=https://beta.rclone.org rclone lsd zz:

Or if you prefer

    export RCLONE_CONFIG_ZZ_TYPE=http
    export RCLONE_CONFIG_ZZ_URL=https://beta.rclone.org
    rclone lsd zz:


Hubic

Paths are specified as remote:path

Paths are specified as remote:container (or remote: for the lsd
command.) You may put subdirectories in too, eg
remote:container/path/to/dir.

The initial setup for Hubic involves getting a token from Hubic which
you need to do in your browser. rclone config walks you through it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    n) New remote
    s) Set configuration password
    n/s> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 8
    Hubic Client Id - leave blank normally.
    client_id>
    Hubic Client Secret - leave blank normally.
    client_secret>
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    client_id =
    client_secret =
    token = {"access_token":"XXXXXX"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See the remote setup docs for how to set it up on a machine with no
Internet browser available.

Note that rclone runs a webserver on your local machine to collect the
token as returned from Hubic. This only runs from the moment it opens
your browser to the moment you get back the verification code. This is
on http://127.0.0.1:53682/ and this it may require you to unblock it
temporarily if you are running a host firewall.

Once configured you can then use rclone like this,

List containers in the top level of your Hubic

    rclone lsd remote:

List all the files in your Hubic

    rclone ls remote:

To copy a local directory to an Hubic directory called backup

    rclone copy /home/source remote:backup

If you want the directory to be visible in the official _Hubic browser_,
you need to copy your files to the default directory

    rclone copy /home/source remote:default/backup

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

The modified time is stored as metadata on the object as
X-Object-Meta-Mtime as floating point since the epoch accurate to 1 ns.

This is a defacto standard (used in the official python-swiftclient
amongst others) for storing the modification time for an object.

Note that Hubic wraps the Swift backend, so most of the properties of
are the same.

Limitations

This uses the normal OpenStack Swift mechanism to refresh the Swift API
credentials and ignores the expires field returned by the Hubic API.

The Swift API doesn't return a correct MD5SUM for segmented files
(Dynamic or Static Large Objects) so rclone won't check or use the
MD5SUM for these.


Microsoft Azure Blob Storage

Paths are specified as remote:container (or remote: for the lsd
command.) You may put subdirectories in too, eg
remote:container/path/to/dir.

Here is an example of making a Microsoft Azure Blob Storage
configuration. For a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Box
       \ "box"
     5 / Dropbox
       \ "dropbox"
     6 / Encrypt/Decrypt a remote
       \ "crypt"
     7 / FTP Connection
       \ "ftp"
     8 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     9 / Google Drive
       \ "drive"
    10 / Hubic
       \ "hubic"
    11 / Local Disk
       \ "local"
    12 / Microsoft Azure Blob Storage
       \ "azureblob"
    13 / Microsoft OneDrive
       \ "onedrive"
    14 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    15 / SSH/SFTP Connection
       \ "sftp"
    16 / Yandex Disk
       \ "yandex"
    17 / http Connection
       \ "http"
    Storage> azureblob
    Storage Account Name
    account> account_name
    Storage Account Key
    key> base64encodedkey==
    Endpoint for the service - leave blank normally.
    endpoint> 
    Remote config
    --------------------
    [remote]
    account = account_name
    key = base64encodedkey==
    endpoint = 
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See all containers

    rclone lsd remote:

Make a new container

    rclone mkdir remote:container

List the contents of a container

    rclone ls remote:container

Sync /home/local/directory to the remote container, deleting any excess
files in the container.

    rclone sync /home/local/directory remote:container

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

The modified time is stored as metadata on the object with the mtime
key. It is stored using RFC3339 Format time with nanosecond precision.
The metadata is supplied during directory listings so there is no
overhead to using it.

Hashes

MD5 hashes are stored with blobs. However blobs that were uploaded in
chunks only have an MD5 if the source remote was capable of MD5 hashes,
eg the local disk.

Multipart uploads

Rclone supports multipart uploads with Azure Blob storage. Files bigger
than 256MB will be uploaded using chunked upload by default.

The files will be uploaded in parallel in 4MB chunks (by default). Note
that these chunks are buffered in memory and there may be up to
--transfers of them being uploaded at once.

Files can't be split into more than 50,000 chunks so by default, so the
largest file that can be uploaded with 4MB chunk size is 195GB. Above
this rclone will double the chunk size until it creates less than 50,000
chunks. By default this will mean a maximum file size of 3.2TB can be
uploaded. This can be raised to 5TB using --azureblob-chunk-size 100M.

Note that rclone doesn't commit the block list until the end of the
upload which means that there is a limit of 9.5TB of multipart uploads
in progress as Azure won't allow more than that amount of uncommitted
blocks.

Specific options

Here are the command line options specific to this cloud storage system.

--azureblob-upload-cutoff=SIZE

Cutoff for switching to chunked upload - must be <= 256MB. The default
is 256MB.

--azureblob-chunk-size=SIZE

Upload chunk size. Default 4MB. Note that this is stored in memory and
there may be up to --transfers chunks stored at once in memory. This can
be at most 100MB.

Limitations

MD5 sums are only uploaded with chunked files if the source has an MD5
sum. This will always be the case for a local to azure copy.


Microsoft OneDrive

Paths are specified as remote:path

Paths may be as deep as required, eg remote:directory/subdirectory.

The initial setup for OneDrive involves getting a token from Microsoft
which you need to do in your browser. rclone config walks you through
it.

Here is an example of how to make a remote called remote. First run:

     rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    n/s> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 10
    Microsoft App Client Id - leave blank normally.
    client_id>
    Microsoft App Client Secret - leave blank normally.
    client_secret>
    Remote config
    Choose OneDrive account type?
     * Say b for a OneDrive business account
     * Say p for a personal OneDrive account
    b) Business
    p) Personal
    b/p> p
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    client_id =
    client_secret =
    token = {"access_token":"XXXXXX"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See the remote setup docs for how to set it up on a machine with no
Internet browser available.

Note that rclone runs a webserver on your local machine to collect the
token as returned from Microsoft. This only runs from the moment it
opens your browser to the moment you get back the verification code.
This is on http://127.0.0.1:53682/ and this it may require you to
unblock it temporarily if you are running a host firewall.

Once configured you can then use rclone like this,

List directories in top level of your OneDrive

    rclone lsd remote:

List all the files in your OneDrive

    rclone ls remote:

To copy a local directory to an OneDrive directory called backup

    rclone copy /home/source remote:backup

OneDrive for Business

There is additional support for OneDrive for Business. Select "b" when
ask

    Choose OneDrive account type?
     * Say b for a OneDrive business account
     * Say p for a personal OneDrive account
    b) Business
    p) Personal
    b/p> 

After that rclone requires an authentication of your account. The
application will first authenticate your account, then query the
OneDrive resource URL and do a second (silent) authentication for this
resource URL.

Modified time and hashes

OneDrive allows modification times to be set on objects accurate to 1
second. These will be used to detect whether objects need syncing or
not.

One drive supports SHA1 type hashes, so you can use --checksum flag.

Deleting files

Any files you delete with rclone will end up in the trash. Microsoft
doesn't provide an API to permanently delete files, nor to empty the
trash, so you will have to do that with one of Microsoft's apps or via
the OneDrive website.

Specific options

Here are the command line options specific to this cloud storage system.

--onedrive-chunk-size=SIZE

Above this size files will be chunked - must be multiple of 320k. The
default is 10MB. Note that the chunks will be buffered into memory.

--onedrive-upload-cutoff=SIZE

Cutoff for switching to chunked upload - must be <= 100MB. The default
is 10MB.

Limitations

Note that OneDrive is case insensitive so you can't have a file called
"Hello.doc" and one called "hello.doc".

There are quite a few characters that can't be in OneDrive file names.
These can't occur on Windows platforms, but on non-Windows platforms
they are common. Rclone will map these names to and from an identical
looking unicode equivalent. For example if a file has a ? in it will be
mapped to ？ instead.

The largest allowed file size is 10GiB (10,737,418,240 bytes).


QingStor

Paths are specified as remote:bucket (or remote: for the lsd command.)
You may put subdirectories in too, eg remote:bucket/path/to/dir.

Here is an example of making an QingStor configuration. First run

    rclone config

This will guide you through an interactive setup process.

    No remotes found - make a new one
    n) New remote
    r) Rename remote
    c) Copy remote
    s) Set configuration password
    q) Quit config
    n/r/c/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / QingStor Object Storage
       \ "qingstor"
    14 / SSH/SFTP Connection
       \ "sftp"
    15 / Yandex Disk
       \ "yandex"
    Storage> 13
    Get QingStor credentials from runtime. Only applies if access_key_id and secret_access_key is blank.
    Choose a number from below, or type in your own value
     1 / Enter QingStor credentials in the next step
       \ "false"
     2 / Get QingStor credentials from the environment (env vars or IAM)
       \ "true"
    env_auth> 1
    QingStor Access Key ID - leave blank for anonymous access or runtime credentials.
    access_key_id> access_key
    QingStor Secret Access Key (password) - leave blank for anonymous access or runtime credentials.
    secret_access_key> secret_key
    Enter a endpoint URL to connection QingStor API.
    Leave blank will use the default value "https://qingstor.com:443"
    endpoint>
    Zone connect to. Default is "pek3a".
    Choose a number from below, or type in your own value
       / The Beijing (China) Three Zone
     1 | Needs location constraint pek3a.
       \ "pek3a"
       / The Shanghai (China) First Zone
     2 | Needs location constraint sh1a.
       \ "sh1a"
    zone> 1
    Number of connnection retry.
    Leave blank will use the default value "3".
    connection_retries>
    Remote config
    --------------------
    [remote]
    env_auth = false
    access_key_id = access_key
    secret_access_key = secret_key
    endpoint =
    zone = pek3a
    connection_retries =
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all buckets

    rclone lsd remote:

Make a new bucket

    rclone mkdir remote:bucket

List the contents of a bucket

    rclone ls remote:bucket

Sync /home/local/directory to the remote bucket, deleting any excess
files in the bucket.

    rclone sync /home/local/directory remote:bucket

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Multipart uploads

rclone supports multipart uploads with QingStor which means that it can
upload files bigger than 5GB. Note that files uploaded with multipart
upload don't have an MD5SUM.

Buckets and Zone

With QingStor you can list buckets (rclone lsd) using any zone, but you
can only access the content of a bucket from the zone it was created in.
If you attempt to access a bucket from the wrong zone, you will get an
error, incorrect zone, the bucket is not in 'XXX' zone.

Authentication

There are two ways to supply rclone with a set of QingStor credentials.
In order of precedence:

-   Directly in the rclone configuration file (as configured by
    rclone config)
-   set access_key_id and secret_access_key
-   Runtime configuration:
-   set env_auth to true in the config file
-   Exporting the following environment variables before running rclone
    -   Access Key ID: QS_ACCESS_KEY_ID or QS_ACCESS_KEY
    -   Secret Access Key: QS_SECRET_ACCESS_KEY or QS_SECRET_KEY


Swift

Swift refers to Openstack Object Storage. Commercial implementations of
that being:

-   Rackspace Cloud Files
-   Memset Memstore
-   OVH Object Storage
-   Oracle Cloud Storage

Paths are specified as remote:container (or remote: for the lsd
command.) You may put subdirectories in too, eg
remote:container/path/to/dir.

Here is an example of making a swift configuration. First run

    rclone config

This will guide you through an interactive setup process.

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Box
       \ "box"
     5 / Dropbox
       \ "dropbox"
     6 / Encrypt/Decrypt a remote
       \ "crypt"
     7 / FTP Connection
       \ "ftp"
     8 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     9 / Google Drive
       \ "drive"
    10 / Hubic
       \ "hubic"
    11 / Local Disk
       \ "local"
    12 / Microsoft Azure Blob Storage
       \ "azureblob"
    13 / Microsoft OneDrive
       \ "onedrive"
    14 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    15 / QingClound Object Storage
       \ "qingstor"
    16 / SSH/SFTP Connection
       \ "sftp"
    17 / Yandex Disk
       \ "yandex"
    18 / http Connection
       \ "http"
    Storage> swift
    Get swift credentials from environment variables in standard OpenStack form.
    Choose a number from below, or type in your own value
     1 / Enter swift credentials in the next step
       \ "false"
     2 / Get swift credentials from environment vars. Leave other fields blank if using this.
       \ "true"
    env_auth> 1
    User name to log in.
    user> user_name
    API key or password.
    key> password_or_api_key
    Authentication URL for server.
    Choose a number from below, or type in your own value
     1 / Rackspace US
       \ "https://auth.api.rackspacecloud.com/v1.0"
     2 / Rackspace UK
       \ "https://lon.auth.api.rackspacecloud.com/v1.0"
     3 / Rackspace v2
       \ "https://identity.api.rackspacecloud.com/v2.0"
     4 / Memset Memstore UK
       \ "https://auth.storage.memset.com/v1.0"
     5 / Memset Memstore UK v2
       \ "https://auth.storage.memset.com/v2.0"
     6 / OVH
       \ "https://auth.cloud.ovh.net/v2.0"
    auth> 1
    User domain - optional (v3 auth)
    domain> Default
    Tenant name - optional for v1 auth, required otherwise
    tenant> tenant_name
    Tenant domain - optional (v3 auth)
    tenant_domain>
    Region name - optional
    region>
    Storage URL - optional
    storage_url>
    AuthVersion - optional - set to (1,2,3) if your auth URL has no version
    auth_version>
    Endpoint type to choose from the service catalogue
    Choose a number from below, or type in your own value
     1 / Public (default, choose this if not sure)
       \ "public"
     2 / Internal (use internal service net)
       \ "internal"
     3 / Admin
       \ "admin"
    endpoint_type>
    Remote config
    --------------------
    [remote]
    env_auth = false
    user = user_name
    key = password_or_api_key
    auth = https://auth.api.rackspacecloud.com/v1.0
    domain = Default
    tenant =
    tenant_domain =
    region =
    storage_url =
    auth_version =
    endpoint_type =
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all containers

    rclone lsd remote:

Make a new container

    rclone mkdir remote:container

List the contents of a container

    rclone ls remote:container

Sync /home/local/directory to the remote container, deleting any excess
files in the container.

    rclone sync /home/local/directory remote:container

Configuration from an Openstack credentials file

An Opentstack credentials file typically looks something something like
this (without the comments)

    export OS_AUTH_URL=https://a.provider.net/v2.0
    export OS_TENANT_ID=ffffffffffffffffffffffffffffffff
    export OS_TENANT_NAME="1234567890123456"
    export OS_USERNAME="123abc567xy"
    echo "Please enter your OpenStack Password: "
    read -sr OS_PASSWORD_INPUT
    export OS_PASSWORD=$OS_PASSWORD_INPUT
    export OS_REGION_NAME="SBG1"
    if [ -z "$OS_REGION_NAME" ]; then unset OS_REGION_NAME; fi

The config file needs to look something like this where $OS_USERNAME
represents the value of the OS_USERNAME variable - 123abc567xy in the
example above.

    [remote]
    type = swift
    user = $OS_USERNAME
    key = $OS_PASSWORD
    auth = $OS_AUTH_URL
    tenant = $OS_TENANT_NAME

Note that you may (or may not) need to set region too - try without
first.

Configuration from the environment

If you prefer you can configure rclone to use swift using a standard set
of OpenStack environment variables.

When you run through the config, make sure you choose true for env_auth
and leave everything else blank.

rclone will then set any empty config parameters from the enviroment
using standard OpenStack environment variables. There is a list of the
variables in the docs for the swift library.

Using rclone without a config file

You can use rclone with swift without a config file, if desired, like
this:

    source openstack-credentials-file
    export RCLONE_CONFIG_MYREMOTE_TYPE=swift
    export RCLONE_CONFIG_MYREMOTE_ENV_AUTH=true
    rclone lsd myremote:

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Specific options

Here are the command line options specific to this cloud storage system.

--swift-chunk-size=SIZE

Above this size files will be chunked into a _segments container. The
default for this is 5GB which is its maximum value.

Modified time

The modified time is stored as metadata on the object as
X-Object-Meta-Mtime as floating point since the epoch accurate to 1 ns.

This is a defacto standard (used in the official python-swiftclient
amongst others) for storing the modification time for an object.

Limitations

The Swift API doesn't return a correct MD5SUM for segmented files
(Dynamic or Static Large Objects) so rclone won't check or use the
MD5SUM for these.

Troubleshooting

Rclone gives Failed to create file system for "remote:": Bad Request

Due to an oddity of the underlying swift library, it gives a "Bad
Request" error rather than a more sensible error when the authentication
fails for Swift.

So this most likely means your username / password is wrong. You can
investigate further with the --dump-bodies flag.

This may also be caused by specifying the region when you shouldn't have
(eg OVH).

Rclone gives Failed to create file system: Response didn't have storage storage url and auth token

This is most likely caused by forgetting to specify your tenant when
setting up a swift remote.


SFTP

SFTP is the Secure (or SSH) File Transfer Protocol.

It runs over SSH v2 and is standard with most modern SSH installations.

Paths are specified as remote:path. If the path does not begin with a /
it is relative to the home directory of the user. An empty path remote:
refers to the users home directory.

Here is an example of making a SFTP configuration. First run

    rclone config

This will guide you through an interactive setup process.

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    q) Quit config
    n/s/q> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / FTP Connection
       \ "ftp"
     7 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     8 / Google Drive
       \ "drive"
     9 / Hubic
       \ "hubic"
    10 / Local Disk
       \ "local"
    11 / Microsoft OneDrive
       \ "onedrive"
    12 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    13 / SSH/SFTP Connection
       \ "sftp"
    14 / Yandex Disk
       \ "yandex"
    15 / http Connection
       \ "http"
    Storage> sftp
    SSH host to connect to
    Choose a number from below, or type in your own value
     1 / Connect to example.com
       \ "example.com"
    host> example.com
    SSH username, leave blank for current username, ncw
    user> sftpuser
    SSH port, leave blank to use default (22)
    port> 
    SSH password, leave blank to use ssh-agent.
    y) Yes type in my own password
    g) Generate random password
    n) No leave this optional password blank
    y/g/n> n
    Path to unencrypted PEM-encoded private key file, leave blank to use ssh-agent.
    key_file> 
    Remote config
    --------------------
    [remote]
    host = example.com
    user = sftpuser
    port = 
    pass = 
    key_file = 
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

This remote is called remote and can now be used like this

See all directories in the home directory

    rclone lsd remote:

Make a new directory

    rclone mkdir remote:path/to/directory

List the contents of a directory

    rclone ls remote:path/to/directory

Sync /home/local/directory to the remote directory, deleting any excess
files in the directory.

    rclone sync /home/local/directory remote:directory

SSH Authentication

The SFTP remote supports 3 authentication methods

-   Password
-   Key file
-   ssh-agent

Key files should be unencrypted PEM-encoded private key files. For
instance /home/$USER/.ssh/id_rsa.

If you don't specify pass or key_file then it will attempt to contact an
ssh-agent.

ssh-agent on macOS

Note that there seem to be various problems with using an ssh-agent on
macOS due to recent changes in the OS. The most effective work-around
seems to be to start an ssh-agent in each session, eg

    eval `ssh-agent -s` && ssh-add -A

And then at the end of the session

    eval `ssh-agent -k`

These commands can be used in scripts of course.

Modified time

Modified times are stored on the server to 1 second precision.

Modified times are used in syncing and are fully supported.

Limitations

SFTP supports checksums if the same login has shell access and md5sum or
sha1sum as well as echo are in the remote's PATH.

The only ssh agent supported under Windows is Putty's pagent.

SFTP isn't supported under plan9 until this issue is fixed.

Note that since SFTP isn't HTTP based the following flags don't work
with it: --dump-headers, --dump-bodies, --dump-auth

Note that --timeout isn't supported (but --contimeout is).


Yandex Disk

Yandex Disk is a cloud storage solution created by Yandex.

Yandex paths may be as deep as required, eg
remote:directory/subdirectory.

Here is an example of making a yandex configuration. First run

    rclone config

This will guide you through an interactive setup process:

    No remotes found - make a new one
    n) New remote
    s) Set configuration password
    n/s> n
    name> remote
    Type of storage to configure.
    Choose a number from below, or type in your own value
     1 / Amazon Drive
       \ "amazon cloud drive"
     2 / Amazon S3 (also Dreamhost, Ceph, Minio)
       \ "s3"
     3 / Backblaze B2
       \ "b2"
     4 / Dropbox
       \ "dropbox"
     5 / Encrypt/Decrypt a remote
       \ "crypt"
     6 / Google Cloud Storage (this is not Google Drive)
       \ "google cloud storage"
     7 / Google Drive
       \ "drive"
     8 / Hubic
       \ "hubic"
     9 / Local Disk
       \ "local"
    10 / Microsoft OneDrive
       \ "onedrive"
    11 / Openstack Swift (Rackspace Cloud Files, Memset Memstore, OVH)
       \ "swift"
    12 / SSH/SFTP Connection
       \ "sftp"
    13 / Yandex Disk
       \ "yandex"
    Storage> 13
    Yandex Client Id - leave blank normally.
    client_id>
    Yandex Client Secret - leave blank normally.
    client_secret>
    Remote config
    Use auto config?
     * Say Y if not sure
     * Say N if you are working on a remote or headless machine
    y) Yes
    n) No
    y/n> y
    If your browser doesn't open automatically go to the following link: http://127.0.0.1:53682/auth
    Log in and authorize rclone for access
    Waiting for code...
    Got code
    --------------------
    [remote]
    client_id =
    client_secret =
    token = {"access_token":"xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx","token_type":"bearer","expiry":"2016-12-29T12:27:11.362788025Z"}
    --------------------
    y) Yes this is OK
    e) Edit this remote
    d) Delete this remote
    y/e/d> y

See the remote setup docs for how to set it up on a machine with no
Internet browser available.

Note that rclone runs a webserver on your local machine to collect the
token as returned from Yandex Disk. This only runs from the moment it
opens your browser to the moment you get back the verification code.
This is on http://127.0.0.1:53682/ and this it may require you to
unblock it temporarily if you are running a host firewall.

Once configured you can then use rclone like this,

See top level directories

    rclone lsd remote:

Make a new directory

    rclone mkdir remote:directory

List the contents of a directory

    rclone ls remote:directory

Sync /home/local/directory to the remote path, deleting any excess files
in the path.

    rclone sync /home/local/directory remote:directory

--fast-list

This remote supports --fast-list which allows you to use fewer
transactions in exchange for more memory. See the rclone docs for more
details.

Modified time

Modified times are supported and are stored accurate to 1 ns in custom
metadata called rclone_modified in RFC3339 with nanoseconds format.

MD5 checksums

MD5 checksums are natively supported by Yandex Disk.

Emptying Trash

If you wish to empty your trash you can use the rclone cleanup remote:
command which will permanently delete all your trashed files. This
command does not take any path arguments.


Local Filesystem

Local paths are specified as normal filesystem paths, eg
/path/to/wherever, so

    rclone sync /home/source /tmp/destination

Will sync /home/source to /tmp/destination

These can be configured into the config file for consistencies sake, but
it is probably easier not to.

Modified time

Rclone reads and writes the modified time using an accuracy determined
by the OS. Typically this is 1ns on Linux, 10 ns on Windows and 1 Second
on OS X.

Filenames

Filenames are expected to be encoded in UTF-8 on disk. This is the
normal case for Windows and OS X.

There is a bit more uncertainty in the Linux world, but new
distributions will have UTF-8 encoded files names. If you are using an
old Linux filesystem with non UTF-8 file names (eg latin1) then you can
use the convmv tool to convert the filesystem to UTF-8. This tool is
available in most distributions' package managers.

If an invalid (non-UTF8) filename is read, the invalid caracters will be
replaced with the unicode replacement character, '�'. rclone will emit a
debug message in this case (use -v to see), eg

    Local file system at .: Replacing invalid UTF-8 characters in "gro\xdf"

Long paths on Windows

Rclone handles long paths automatically, by converting all paths to long
UNC paths which allows paths up to 32,767 characters.

This is why you will see that your paths, for instance c:\files is
converted to the UNC path \\?\c:\files in the output, and \\server\share
is converted to \\?\UNC\server\share.

However, in rare cases this may cause problems with buggy file system
drivers like EncFS. To disable UNC conversion globally, add this to your
.rclone.conf file:

    [local]
    nounc = true

If you want to selectively disable UNC, you can add it to a separate
entry like this:

    [nounc]
    type = local
    nounc = true

And use rclone like this:

rclone copy c:\src nounc:z:\dst

This will use UNC paths on c:\src but not on z:\dst. Of course this will
cause problems if the absolute path length of a file exceeds 258
characters on z, so only use this option if you have to.

Specific options

Here are the command line options specific to local storage

--copy-links, -L

Normally rclone will ignore symlinks or junction points (which behave
like symlinks under Windows).

If you supply this flag then rclone will follow the symlink and copy the
pointed to file or directory.

This flag applies to all commands.

For example, supposing you have a directory structure like this

    $ tree /tmp/a
    /tmp/a
    ├── b -> ../b
    ├── expected -> ../expected
    ├── one
    └── two
        └── three

Then you can see the difference with and without the flag like this

    $ rclone ls /tmp/a
            6 one
            6 two/three

and

    $ rclone -L ls /tmp/a
         4174 expected
            6 one
            6 two/three
            6 b/two
            6 b/one

--local-no-unicode-normalization

This flag is deprecated now. Rclone no longer normalizes unicode file
names, but it compares them with unicode normalization in the sync
routine instead.

--one-file-system, -x

This tells rclone to stay in the filesystem specified by the root and
not to recurse into different file systems.

For example if you have a directory heirachy like this

    root
    ├── disk1     - disk1 mounted on the root
    │   └── file3 - stored on disk1
    ├── disk2     - disk2 mounted on the root
    │   └── file4 - stored on disk12
    ├── file1     - stored on the root disk
    └── file2     - stored on the root disk

Using rclone --one-file-system copy root remote: will only copy file1
and file2. Eg

    $ rclone -q --one-file-system ls root
            0 file1
            0 file2

    $ rclone -q ls root
            0 disk1/file3
            0 disk2/file4
            0 file1
            0 file2

NB Rclone (like most unix tools such as du, rsync and tar) treats a bind
mount to the same device as being on the same filesystem.

NB This flag is only available on Unix based systems. On systems where
it isn't supported (eg Windows) it will not appear as an valid flag.

--skip-links

This flag disables warning messages on skipped symlinks or junction
points, as you explicitly acknowledge that they should be skipped.


Changelog

-   v1.38 - 2017-09-30
    -   New backends
    -   Azure Blob Storage (thanks Andrei Dragomir)
    -   Box
    -   Onedrive for Business (thanks Oliver Heyme)
    -   QingStor from QingCloud (thanks wuyu)
    -   New commands
    -   rcat - read from standard input and stream upload
    -   tree - shows a nicely formatted recursive listing
    -   cryptdecode - decode crypted file names (thanks ishuah)
    -   config show - print the config file
    -   config file - print the config file location
    -   New Features
    -   Empty directories are deleted on sync
    -   dedupe - implement merging of duplicate directories
    -   check and cryptcheck made more consistent and use less memory
    -   cleanup for remaining remotes (thanks ishuah)
    -   --immutable for ensuring that files don't change (thanks
        Jacob McNamee)
    -   --user-agent option (thanks Alex McGrath Kraak)
    -   --disable flag to disable optional features
    -   --bind flag for choosing the local addr on outgoing connections
    -   Support for zsh auto-completion (thanks bpicode)
    -   Stop normalizing file names but do a normalized compare in sync
    -   Compile
    -   Update to using go1.9 as the default go version
    -   Remove snapd build due to maintenance problems
    -   Bug Fixes
    -   Improve retriable error detection which makes multipart uploads
        better
    -   Make check obey --ignore-size
    -   Fix bwlimit toggle in conjunction with schedules
        (thanks cbruegg)
    -   config ensures newly written config is on the same mount
    -   Local
    -   Revert to copy when moving file across file system boundaries
    -   --skip-links to suppress symlink warnings (thanks Zhiming Wang)
    -   Mount
    -   Re-use rcat internals to support uploads from all remotes
    -   Dropbox
    -   Fix "entry doesn't belong in directory" error
    -   Stop using deprecated API methods
    -   Swift
    -   Fix server side copy to empty container with --fast-list
    -   Google Drive
    -   Change the default for --drive-use-trash to true
    -   S3
    -   Set session token when using STS (thanks Girish Ramakrishnan)
    -   Glacier docs and error messages (thanks Jan Varho)
    -   Read 1000 (not 1024) items in dir listings to fix Wasabi
    -   Backblaze B2
    -   Fix SHA1 mismatch when downloading files with no SHA1
    -   Calculate missing hashes on the fly instead of spooling
    -   --b2-hard-delete to permanently delete (not hide) files (thanks
        John Papandriopoulos)
    -   Hubic
    -   Fix creating containers - no longer have to use the default
        container
    -   Swift
    -   Optionally configure from a standard set of OpenStack
        environment vars
    -   Add endpoint_type config
    -   Google Cloud Storage
    -   Fix bucket creation to work with limited permission users
    -   SFTP
    -   Implement connection pooling for multiple ssh connections
    -   Limit new connections per second
    -   Add support for MD5 and SHA1 hashes where available (thanks
        Christian Brüggemann)
    -   HTTP
    -   Fix URL encoding issues
    -   Fix directories with : in
    -   Fix panic with URL encoded content
-   v1.37 - 2017-07-22
    -   New backends
    -   FTP - thanks to Antonio Messina
    -   HTTP - thanks to Vasiliy Tolstov
    -   New commands
    -   rclone ncdu - for exploring a remote with a text based
        user interface.
    -   rclone lsjson - for listing with a machine readable output
    -   rclone dbhashsum - to show Dropbox style hashes of files (local
        or Dropbox)
    -   New Features
    -   Implement --fast-list flag
        -   This allows remotes to list recursively if they can
        -   This uses less transactions (important if you pay for them)
        -   This may or may not be quicker
        -   This will use more memory as it has to hold the listing in
            memory
        -   --old-sync-method deprecated - the remaining uses are
            covered by --fast-list
        -   This involved a major re-write of all the listing code
    -   Add --tpslimit and --tpslimit-burst to limit transactions per
        second
        -   this is useful in conjuction with rclone mount to limit
            external apps
    -   Add --stats-log-level so can see --stats without -v
    -   Print password prompts to stderr - Hraban Luyat
    -   Warn about duplicate files when syncing
    -   Oauth improvements
        -   allow auth_url and token_url to be set in the config file
        -   Print redirection URI if using own credentials.
    -   Don't Mkdir at the start of sync to save transactions
    -   Compile
    -   Update build to go1.8.3
    -   Require go1.6 for building rclone
    -   Compile 386 builds with "GO386=387" for maximum compatibility
    -   Bug Fixes
    -   Fix menu selection when no remotes
    -   Config saving reworked to not kill the file if disk gets full
    -   Don't delete remote if name does not change while renaming
    -   moveto, copyto: report transfers and checks as per move and copy
    -   Local
    -   Add --local-no-unicode-normalization flag - Bob Potter
    -   Mount
    -   Now supported on Windows using cgofuse and WinFsp - thanks to
        Bill Zissimopoulos for much help
    -   Compare checksums on upload/download via FUSE
    -   Unmount when program ends with SIGINT (Ctrl+C) or SIGTERM -
        Jérôme Vizcaino
    -   On read only open of file, make open pending until first read
    -   Make --read-only reject modify operations
    -   Implement ModTime via FUSE for remotes that support it
    -   Allow modTime to be changed even before all writers are closed
    -   Fix panic on renames
    -   Fix hang on errored upload
    -   Crypt
    -   Report the name:root as specified by the user
    -   Add an "obfuscate" option for filename encryption - Stephen
        Harris
    -   Amazon Drive
    -   Fix initialization order for token renewer
    -   Remove revoked credentials, allow oauth proxy config and update
        docs
    -   B2
    -   Reduce minimum chunk size to 5MB
    -   Drive
    -   Add team drive support
    -   Reduce bandwidth by adding fields for partial responses - Martin
        Kristensen
    -   Implement --drive-shared-with-me flag to view shared with me
        files - Danny Tsai
    -   Add --drive-trashed-only to read only the files in the trash
    -   Remove obsolete --drive-full-list
    -   Add missing seek to start on retries of chunked uploads
    -   Fix stats accounting for upload
    -   Convert / in names to a unicode equivalent (／)
    -   Poll for Google Drive changes when mounted
    -   OneDrive
    -   Fix the uploading of files with spaces
    -   Fix initialization order for token renewer
    -   Display speeds accurately when uploading - Yoni Jah
    -   Swap to using http://localhost:53682/ as redirect URL - Michael
        Ledin
    -   Retry on token expired error, reset upload body on retry - Yoni
        Jah
    -   Google Cloud Storage
    -   Add ability to specify location and storage class via config and
        command line - thanks gdm85
    -   Create container if necessary on server side copy
    -   Increase directory listing chunk to 1000 to increase performance
    -   Obtain a refresh token for GCS - Steven Lu
    -   Yandex
    -   Fix the name reported in log messages (was empty)
    -   Correct error return for listing empty directory
    -   Dropbox
    -   Rewritten to use the v2 API
        -   Now supports ModTime
        -   Can only set by uploading the file again
        -   If you uploaded with an old rclone, rclone may upload
            everything again
        -   Use --size-only or --checksum to avoid this
        -   Now supports the Dropbox content hashing scheme
        -   Now supports low level retries
    -   S3
    -   Work around eventual consistency in bucket creation
    -   Create container if necessary on server side copy
    -   Add us-east-2 (Ohio) and eu-west-2 (London) S3 regions - Zahiar
        Ahmed
    -   Swift, Hubic
    -   Fix zero length directory markers showing in the subdirectory
        listing
        -   this caused lots of duplicate transfers
    -   Fix paged directory listings
        -   this caused duplicate directory errors
    -   Create container if necessary on server side copy
    -   Increase directory listing chunk to 1000 to increase performance
    -   Make sensible error if the user forgets the container
    -   SFTP
    -   Add support for using ssh key files
    -   Fix under Windows
    -   Fix ssh agent on Windows
    -   Adapt to latest version of library - Igor Kharin
-   v1.36 - 2017-03-18
    -   New Features
    -   SFTP remote (Jack Schmidt)
    -   Re-implement sync routine to work a directory at a time reducing
        memory usage
    -   Logging revamped to be more inline with rsync - now much quieter
        -   -v only shows transfers
        -   -vv is for full debug
        -   --syslog to log to syslog on capable platforms
    -   Implement --backup-dir and --suffix
    -   Implement --track-renames (initial implementation by Bjørn
        Erik Pedersen)
    -   Add time-based bandwidth limits (Lukas Loesche)
    -   rclone cryptcheck: checks integrity of crypt remotes
    -   Allow all config file variables and options to be set from
        environment variables
    -   Add --buffer-size parameter to control buffer size for copy
    -   Make --delete-after the default
    -   Add --ignore-checksum flag (fixed by Hisham Zarka)
    -   rclone check: Add --download flag to check all the data, not
        just hashes
    -   rclone cat: add --head, --tail, --offset, --count and --discard
    -   rclone config: when choosing from a list, allow the value to be
        entered too
    -   rclone config: allow rename and copy of remotes
    -   rclone obscure: for generating encrypted passwords for rclone's
        config (T.C. Ferguson)
    -   Comply with XDG Base Directory specification (Dario Giovannetti)
        -   this moves the default location of the config file in a
            backwards compatible way
    -   Release changes
        -   Ubuntu snap support (Dedsec1)
        -   Compile with go 1.8
        -   MIPS/Linux big and little endian support
    -   Bug Fixes
    -   Fix copyto copying things to the wrong place if the destination
        dir didn't exist
    -   Fix parsing of remotes in moveto and copyto
    -   Fix --delete-before deleting files on copy
    -   Fix --files-from with an empty file copying everything
    -   Fix sync: don't update mod times if --dry-run set
    -   Fix MimeType propagation
    -   Fix filters to add ** rules to directory rules
    -   Local
    -   Implement -L, --copy-links flag to allow rclone to follow
        symlinks
    -   Open files in write only mode so rclone can write to an rclone
        mount
    -   Fix unnormalised unicode causing problems reading directories
    -   Fix interaction between -x flag and --max-depth
    -   Mount
    -   Implement proper directory handling (mkdir, rmdir, renaming)
    -   Make include and exclude filters apply to mount
    -   Implement read and write async buffers - control with
        --buffer-size
    -   Fix fsync on for directories
    -   Fix retry on network failure when reading off crypt
    -   Crypt
    -   Add --crypt-show-mapping to show encrypted file mapping
    -   Fix crypt writer getting stuck in a loop
        -   IMPORTANT this bug had the potential to cause data
            corruption when
        -   reading data from a network based remote and
        -   writing to a crypt on Google Drive
        -   Use the cryptcheck command to validate your data if you are
            concerned
        -   If syncing two crypt remotes, sync the unencrypted remote
    -   Amazon Drive
    -   Fix panics on Move (rename)
    -   Fix panic on token expiry
    -   B2
    -   Fix inconsistent listings and rclone check
    -   Fix uploading empty files with go1.8
    -   Constrain memory usage when doing multipart uploads
    -   Fix upload url not being refreshed properly
    -   Drive
    -   Fix Rmdir on directories with trashed files
    -   Fix "Ignoring unknown object" when downloading
    -   Add --drive-list-chunk
    -   Add --drive-skip-gdocs (Károly Oláh)
    -   OneDrive
    -   Implement Move
    -   Fix Copy
        -   Fix overwrite detection in Copy
        -   Fix waitForJob to parse errors correctly
    -   Use token renewer to stop auth errors on long uploads
    -   Fix uploading empty files with go1.8
    -   Google Cloud Storage
    -   Fix depth 1 directory listings
    -   Yandex
    -   Fix single level directory listing
    -   Dropbox
    -   Normalise the case for single level directory listings
    -   Fix depth 1 listing
    -   S3
    -   Added ca-central-1 region (Jon Yergatian)
-   v1.35 - 2017-01-02
    -   New Features
    -   moveto and copyto commands for choosing a destination name on
        copy/move
    -   rmdirs command to recursively delete empty directories
    -   Allow repeated --include/--exclude/--filter options
    -   Only show transfer stats on commands which transfer stuff
        -   show stats on any command using the --stats flag
    -   Allow overlapping directories in move when server side dir move
        is supported
    -   Add --stats-unit option - thanks Scott McGillivray
    -   Bug Fixes
    -   Fix the config file being overwritten when two rclones are
        running
    -   Make rclone lsd obey the filters properly
    -   Fix compilation on mips
    -   Fix not transferring files that don't differ in size
    -   Fix panic on nil retry/fatal error
    -   Mount
    -   Retry reads on error - should help with reliability a lot
    -   Report the modification times for directories from the remote
    -   Add bandwidth accounting and limiting (fixes --bwlimit)
    -   If --stats provided will show stats and which files are
        transferring
    -   Support R/W files if truncate is set.
    -   Implement statfs interface so df works
    -   Note that write is now supported on Amazon Drive
    -   Report number of blocks in a file - thanks Stefan Breunig
    -   Crypt
    -   Prevent the user pointing crypt at itself
    -   Fix failed to authenticate decrypted block errors
        -   these will now return the underlying unexpected EOF instead
    -   Amazon Drive
    -   Add support for server side move and directory move - thanks
        Stefan Breunig
    -   Fix nil pointer deref on size attribute
    -   B2
    -   Use new prefix and delimiter parameters in directory listings
        -   This makes --max-depth 1 dir listings as used in mount much
            faster
    -   Reauth the account while doing uploads too - should help with
        token expiry
    -   Drive
    -   Make DirMove more efficient and complain about moving the root
    -   Create destination directory on Move()
-   v1.34 - 2016-11-06
    -   New Features
    -   Stop single file and --files-from operations iterating through
        the source bucket.
    -   Stop removing failed upload to cloud storage remotes
    -   Make ContentType be preserved for cloud to cloud copies
    -   Add support to toggle bandwidth limits via SIGUSR2 - thanks
        Marco Paganini
    -   rclone check shows count of hashes that couldn't be checked
    -   rclone listremotes command
    -   Support linux/arm64 build - thanks Fredrik Fornwall
    -   Remove Authorization: lines from --dump-headers output
    -   Bug Fixes
    -   Ignore files with control characters in the names
    -   Fix rclone move command
        -   Delete src files which already existed in dst
        -   Fix deletion of src file when dst file older
    -   Fix rclone check on crypted file systems
    -   Make failed uploads not count as "Transferred"
    -   Make sure high level retries show with -q
    -   Use a vendor directory with godep for repeatable builds
    -   rclone mount - FUSE
    -   Implement FUSE mount options
        -   --no-modtime, --debug-fuse, --read-only, --allow-non-empty,
            --allow-root, --allow-other
        -   --default-permissions, --write-back-cache, --max-read-ahead,
            --umask, --uid, --gid
    -   Add --dir-cache-time to control caching of directory entries
    -   Implement seek for files opened for read (useful for
        video players)
        -   with -no-seek flag to disable
    -   Fix crash on 32 bit ARM (alignment of 64 bit counter)
    -   ...and many more internal fixes and improvements!
    -   Crypt
    -   Don't show encrypted password in configurator to stop confusion
    -   Amazon Drive
    -   New wait for upload option --acd-upload-wait-per-gb
        -   upload timeouts scale by file size and can be disabled
    -   Add 502 Bad Gateway to list of errors we retry
    -   Fix overwriting a file with a zero length file
    -   Fix ACD file size warning limit - thanks Felix Bünemann
    -   Local
    -   Unix: implement -x/--one-file-system to stay on a single file
        system
        -   thanks Durval Menezes and Luiz Carlos Rumbelsperger Viana
    -   Windows: ignore the symlink bit on files
    -   Windows: Ignore directory based junction points
    -   B2
    -   Make sure each upload has at least one upload slot - fixes
        strange upload stats
    -   Fix uploads when using crypt
    -   Fix download of large files (sha1 mismatch)
    -   Return error when we try to create a bucket which someone else
        owns
    -   Update B2 docs with Data usage, and Crypt section - thanks
        Tomasz Mazur
    -   S3
    -   Command line and config file support for
        -   Setting/overriding ACL - thanks Radek Senfeld
        -   Setting storage class - thanks Asko Tamm
    -   Drive
    -   Make exponential backoff work exactly as per Google
        specification
    -   add .epub, .odp and .tsv as export formats.
    -   Swift
    -   Don't read metadata for directory marker objects
-   v1.33 - 2016-08-24
    -   New Features
    -   Implement encryption
        -   data encrypted in NACL secretbox format
        -   with optional file name encryption
    -   New commands
        -   rclone mount - implements FUSE mounting of
            remotes (EXPERIMENTAL)
        -   works on Linux, FreeBSD and OS X (need testers for the
            last 2!)
        -   rclone cat - outputs remote file or files to the terminal
        -   rclone genautocomplete - command to make a bash completion
            script for rclone
    -   Editing a remote using rclone config now goes through the wizard
    -   Compile with go 1.7 - this fixes rclone on macOS Sierra and on
        386 processors
    -   Use cobra for sub commands and docs generation
    -   drive
    -   Document how to make your own client_id
    -   s3
    -   User-configurable Amazon S3 ACL (thanks Radek Šenfeld)
    -   b2
    -   Fix stats accounting for upload - no more jumping to 100% done
    -   On cleanup delete hide marker if it is the current file
    -   New B2 API endpoint (thanks Per Cederberg)
    -   Set maximum backoff to 5 Minutes
    -   onedrive
    -   Fix URL escaping in file names - eg uploading files with +
        in them.
    -   amazon cloud drive
    -   Fix token expiry during large uploads
    -   Work around 408 REQUEST_TIMEOUT and 504 GATEWAY_TIMEOUT errors
    -   local
    -   Fix filenames with invalid UTF-8 not being uploaded
    -   Fix problem with some UTF-8 characters on OS X
-   v1.32 - 2016-07-13
    -   Backblaze B2
    -   Fix upload of files large files not in root
-   v1.31 - 2016-07-13
    -   New Features
    -   Reduce memory on sync by about 50%
    -   Implement --no-traverse flag to stop copy traversing the
        destination remote.
        -   This can be used to reduce memory usage down to the
            smallest possible.
        -   Useful to copy a small number of files into a large
            destination folder.
    -   Implement cleanup command for emptying trash / removing old
        versions of files
        -   Currently B2 only
    -   Single file handling improved
        -   Now copied with --files-from
        -   Automatically sets --no-traverse when copying a single file
    -   Info on using installing with ansible - thanks Stefan Weichinger
    -   Implement --no-update-modtime flag to stop rclone fixing the
        remote modified times.
    -   Bug Fixes
    -   Fix move command - stop it running for overlapping Fses - this
        was causing data loss.
    -   Local
    -   Fix incomplete hashes - this was causing problems for B2.
    -   Amazon Drive
    -   Rename Amazon Cloud Drive to Amazon Drive - no changes to config
        file needed.
    -   Swift
    -   Add support for non-default project domain - thanks
        Antonio Messina.
    -   S3
    -   Add instructions on how to use rclone with minio.
    -   Add ap-northeast-2 (Seoul) and ap-south-1 (Mumbai) regions.
    -   Skip setting the modified time for objects > 5GB as it
        isn't possible.
    -   Backblaze B2
    -   Add --b2-versions flag so old versions can be listed
        and retreived.
    -   Treat 403 errors (eg cap exceeded) as fatal.
    -   Implement cleanup command for deleting old file versions.
    -   Make error handling compliant with B2 integrations notes.
    -   Fix handling of token expiry.
    -   Implement --b2-test-mode to set X-Bz-Test-Mode header.
    -   Set cutoff for chunked upload to 200MB as per B2 guidelines.
    -   Make upload multi-threaded.
    -   Dropbox
    -   Don't retry 461 errors.
-   v1.30 - 2016-06-18
    -   New Features
    -   Directory listing code reworked for more features and better
        error reporting (thanks to Klaus Post for help). This enables
        -   Directory include filtering for efficiency
        -   --max-depth parameter
        -   Better error reporting
        -   More to come
    -   Retry more errors
    -   Add --ignore-size flag - for uploading images to onedrive
    -   Log -v output to stdout by default
    -   Display the transfer stats in more human readable form
    -   Make 0 size files specifiable with --max-size 0b
    -   Add b suffix so we can specify bytes in --bwlimit, --min-size
        etc
    -   Use "password:" instead of "password>" prompt - thanks Klaus
        Post and Leigh Klotz
    -   Bug Fixes
    -   Fix retry doing one too many retries
    -   Local
    -   Fix problems with OS X and UTF-8 characters
    -   Amazon Drive
    -   Check a file exists before uploading to help with 408 Conflict
        errors
    -   Reauth on 401 errors - this has been causing a lot of problems
    -   Work around spurious 403 errors
    -   Restart directory listings on error
    -   Google Drive
    -   Check a file exists before uploading to help with duplicates
    -   Fix retry of multipart uploads
    -   Backblaze B2
    -   Implement large file uploading
    -   S3
    -   Add AES256 server-side encryption for - thanks Justin R. Wilson
    -   Google Cloud Storage
    -   Make sure we don't use conflicting content types on upload
    -   Add service account support - thanks Michal Witkowski
    -   Swift
    -   Add auth version parameter
    -   Add domain option for openstack (v3 auth) - thanks Fabian Ruff
-   v1.29 - 2016-04-18
    -   New Features
    -   Implement -I, --ignore-times for unconditional upload
    -   Improve dedupecommand
        -   Now removes identical copies without asking
        -   Now obeys --dry-run
        -   Implement --dedupe-mode for non interactive running
        -   --dedupe-mode interactive - interactive the default.
        -   --dedupe-mode skip - removes identical files then skips
            anything left.
        -   --dedupe-mode first - removes identical files then keeps the
            first one.
        -   --dedupe-mode newest - removes identical files then keeps
            the newest one.
        -   --dedupe-mode oldest - removes identical files then keeps
            the oldest one.
        -   --dedupe-mode rename - removes identical files then renames
            the rest to be different.
    -   Bug fixes
    -   Make rclone check obey the --size-only flag.
    -   Use "application/octet-stream" if discovered mime type
        is invalid.
    -   Fix missing "quit" option when there are no remotes.
    -   Google Drive
    -   Increase default chunk size to 8 MB - increases upload speed of
        big files
    -   Speed up directory listings and make more reliable
    -   Add missing retries for Move and DirMove - increases reliability
    -   Preserve mime type on file update
    -   Backblaze B2
    -   Enable mod time syncing
        -   This means that B2 will now check modification times
        -   It will upload new files to update the modification times
        -   (there isn't an API to just set the mod time.)
        -   If you want the old behaviour use --size-only.
    -   Update API to new version
    -   Fix parsing of mod time when not in metadata
    -   Swift/Hubic
    -   Don't return an MD5SUM for static large objects
    -   S3
    -   Fix uploading files bigger than 50GB
-   v1.28 - 2016-03-01
    -   New Features
    -   Configuration file encryption - thanks Klaus Post
    -   Improve rclone config adding more help and making it easier to
        understand
    -   Implement -u/--update so creation times can be used on all
        remotes
    -   Implement --low-level-retries flag
    -   Optionally disable gzip compression on downloads with
        --no-gzip-encoding
    -   Bug fixes
    -   Don't make directories if --dry-run set
    -   Fix and document the move command
    -   Fix redirecting stderr on unix-like OSes when using --log-file
    -   Fix delete command to wait until all finished - fixes
        missing deletes.
    -   Backblaze B2
    -   Use one upload URL per go routine fixes
        more than one upload using auth token
    -   Add pacing, retries and reauthentication - fixes token expiry
        problems
    -   Upload without using a temporary file from local (and remotes
        which support SHA1)
    -   Fix reading metadata for all files when it shouldn't have been
    -   Drive
    -   Fix listing drive documents at root
    -   Disable copy and move for Google docs
    -   Swift
    -   Fix uploading of chunked files with non ASCII characters
    -   Allow setting of storage_url in the config - thanks Xavier Lucas
    -   S3
    -   Allow IAM role and credentials from environment variables -
        thanks Brian Stengaard
    -   Allow low privilege users to use S3 (check if directory exists
        during Mkdir) - thanks Jakub Gedeon
    -   Amazon Drive
    -   Retry on more things to make directory listings more reliable
-   v1.27 - 2016-01-31
    -   New Features
    -   Easier headless configuration with rclone authorize
    -   Add support for multiple hash types - we now check SHA1 as well
        as MD5 hashes.
    -   delete command which does obey the filters (unlike purge)
    -   dedupe command to deduplicate a remote. Useful with
        Google Drive.
    -   Add --ignore-existing flag to skip all files that exist
        on destination.
    -   Add --delete-before, --delete-during, --delete-after flags.
    -   Add --memprofile flag to debug memory use.
    -   Warn the user about files with same name but different case
    -   Make --include rules add their implict exclude * at the end of
        the filter list
    -   Deprecate compiling with go1.3
    -   Amazon Drive
    -   Fix download of files > 10 GB
    -   Fix directory traversal ("Next token is expired") for large
        directory listings
    -   Remove 409 conflict from error codes we will retry - stops very
        long pauses
    -   Backblaze B2
    -   SHA1 hashes now checked by rclone core
    -   Drive
    -   Add --drive-auth-owner-only to only consider files owned by the
        user - thanks Björn Harrtell
    -   Export Google documents
    -   Dropbox
    -   Make file exclusion error controllable with -q
    -   Swift
    -   Fix upload from unprivileged user.
    -   S3
    -   Fix updating of mod times of files with + in.
    -   Local
    -   Add local file system option to disable UNC on Windows.
-   v1.26 - 2016-01-02
    -   New Features
    -   Yandex storage backend - thank you Dmitry Burdeev ("dibu")
    -   Implement Backblaze B2 storage backend
    -   Add --min-age and --max-age flags - thank you Adriano Aurélio
        Meirelles
    -   Make ls/lsl/md5sum/size/check obey includes and excludes
    -   Fixes
    -   Fix crash in http logging
    -   Upload releases to github too
    -   Swift
    -   Fix sync for chunked files
    -   OneDrive
    -   Re-enable server side copy
    -   Don't mask HTTP error codes with JSON decode error
    -   S3
    -   Fix corrupting Content-Type on mod time update (thanks
        Joseph Spurrier)
-   v1.25 - 2015-11-14
    -   New features
    -   Implement Hubic storage system
    -   Fixes
    -   Fix deletion of some excluded files without --delete-excluded
        -   This could have deleted files unexpectedly on sync
        -   Always check first with --dry-run!
    -   Swift
    -   Stop SetModTime losing metadata (eg X-Object-Manifest)
        -   This could have caused data loss for files > 5GB in size
    -   Use ContentType from Object to avoid lookups in listings
    -   OneDrive
    -   disable server side copy as it seems to be broken at Microsoft
-   v1.24 - 2015-11-07
    -   New features
    -   Add support for Microsoft OneDrive
    -   Add --no-check-certificate option to disable server certificate
        verification
    -   Add async readahead buffer for faster transfer of big files
    -   Fixes
    -   Allow spaces in remotes and check remote names for validity at
        creation time
    -   Allow '&' and disallow ':' in Windows filenames.
    -   Swift
    -   Ignore directory marker objects where appropriate - allows
        working with Hubic
    -   Don't delete the container if fs wasn't at root
    -   S3
    -   Don't delete the bucket if fs wasn't at root
    -   Google Cloud Storage
    -   Don't delete the bucket if fs wasn't at root
-   v1.23 - 2015-10-03
    -   New features
    -   Implement rclone size for measuring remotes
    -   Fixes
    -   Fix headless config for drive and gcs
    -   Tell the user they should try again if the webserver method
        failed
    -   Improve output of --dump-headers
    -   S3
    -   Allow anonymous access to public buckets
    -   Swift
    -   Stop chunked operations logging "Failed to read info: Object Not
        Found"
    -   Use Content-Length on uploads for extra reliability
-   v1.22 - 2015-09-28
    -   Implement rsync like include and exclude flags
    -   swift
    -   Support files > 5GB - thanks Sergey Tolmachev
-   v1.21 - 2015-09-22
    -   New features
    -   Display individual transfer progress
    -   Make lsl output times in localtime
    -   Fixes
    -   Fix allowing user to override credentials again in Drive, GCS
        and ACD
    -   Amazon Drive
    -   Implement compliant pacing scheme
    -   Google Drive
    -   Make directory reads concurrent for increased speed.
-   v1.20 - 2015-09-15
    -   New features
    -   Amazon Drive support
    -   Oauth support redone - fix many bugs and improve usability
        -   Use "golang.org/x/oauth2" as oauth libary of choice
        -   Improve oauth usability for smoother initial signup
        -   drive, googlecloudstorage: optionally use auto config for
            the oauth token
    -   Implement --dump-headers and --dump-bodies debug flags
    -   Show multiple matched commands if abbreviation too short
    -   Implement server side move where possible
    -   local
    -   Always use UNC paths internally on Windows - fixes a lot of bugs
    -   dropbox
    -   force use of our custom transport which makes timeouts work
    -   Thanks to Klaus Post for lots of help with this release
-   v1.19 - 2015-08-28
    -   New features
    -   Server side copies for s3/swift/drive/dropbox/gcs
    -   Move command - uses server side copies if it can
    -   Implement --retries flag - tries 3 times by default
    -   Build for plan9/amd64 and solaris/amd64 too
    -   Fixes
    -   Make a current version download with a fixed URL for scripting
    -   Ignore rmdir in limited fs rather than throwing error
    -   dropbox
    -   Increase chunk size to improve upload speeds massively
    -   Issue an error message when trying to upload bad file name
-   v1.18 - 2015-08-17
    -   drive
    -   Add --drive-use-trash flag so rclone trashes instead of deletes
    -   Add "Forbidden to download" message for files with no
        downloadURL
    -   dropbox
    -   Remove datastore
        -   This was deprecated and it caused a lot of problems
        -   Modification times and MD5SUMs no longer stored
    -   Fix uploading files > 2GB
    -   s3
    -   use official AWS SDK from github.com/aws/aws-sdk-go
    -   NB will most likely require you to delete and recreate remote
    -   enable multipart upload which enables files > 5GB
    -   tested with Ceph / RadosGW / S3 emulation
    -   many thanks to Sam Liston and Brian Haymore at the Utah Center
        for High Performance Computing for a Ceph test account
    -   misc
    -   Show errors when reading the config file
    -   Do not print stats in quiet mode - thanks Leonid Shalupov
    -   Add FAQ
    -   Fix created directories not obeying umask
    -   Linux installation instructions - thanks Shimon Doodkin
-   v1.17 - 2015-06-14
    -   dropbox: fix case insensitivity issues - thanks Leonid Shalupov
-   v1.16 - 2015-06-09
    -   Fix uploading big files which was causing timeouts or panics
    -   Don't check md5sum after download with --size-only
-   v1.15 - 2015-06-06
    -   Add --checksum flag to only discard transfers by MD5SUM - thanks
        Alex Couper
    -   Implement --size-only flag to sync on size not checksum &
        modtime
    -   Expand docs and remove duplicated information
    -   Document rclone's limitations with directories
    -   dropbox: update docs about case insensitivity
-   v1.14 - 2015-05-21
    -   local: fix encoding of non utf-8 file names - fixes a duplicate
        file problem
    -   drive: docs about rate limiting
    -   google cloud storage: Fix compile after API change in
        "google.golang.org/api/storage/v1"
-   v1.13 - 2015-05-10
    -   Revise documentation (especially sync)
    -   Implement --timeout and --conntimeout
    -   s3: ignore etags from multipart uploads which aren't md5sums
-   v1.12 - 2015-03-15
    -   drive: Use chunked upload for files above a certain size
    -   drive: add --drive-chunk-size and --drive-upload-cutoff
        parameters
    -   drive: switch to insert from update when a failed copy deletes
        the upload
    -   core: Log duplicate files if they are detected
-   v1.11 - 2015-03-04
    -   swift: add region parameter
    -   drive: fix crash on failed to update remote mtime
    -   In remote paths, change native directory separators to /
    -   Add synchronization to ls/lsl/lsd output to stop corruptions
    -   Ensure all stats/log messages to go stderr
    -   Add --log-file flag to log everything (including panics) to file
    -   Make it possible to disable stats printing with --stats=0
    -   Implement --bwlimit to limit data transfer bandwidth
-   v1.10 - 2015-02-12
    -   s3: list an unlimited number of items
    -   Fix getting stuck in the configurator
-   v1.09 - 2015-02-07
    -   windows: Stop drive letters (eg C:) getting mixed up with
        remotes (eg drive:)
    -   local: Fix directory separators on Windows
    -   drive: fix rate limit exceeded errors
-   v1.08 - 2015-02-04
    -   drive: fix subdirectory listing to not list entire drive
    -   drive: Fix SetModTime
    -   dropbox: adapt code to recent library changes
-   v1.07 - 2014-12-23
    -   google cloud storage: fix memory leak
-   v1.06 - 2014-12-12
    -   Fix "Couldn't find home directory" on OSX
    -   swift: Add tenant parameter
    -   Use new location of Google API packages
-   v1.05 - 2014-08-09
    -   Improved tests and consequently lots of minor fixes
    -   core: Fix race detected by go race detector
    -   core: Fixes after running errcheck
    -   drive: reset root directory on Rmdir and Purge
    -   fs: Document that Purger returns error on empty directory, test
        and fix
    -   google cloud storage: fix ListDir on subdirectory
    -   google cloud storage: re-read metadata in SetModTime
    -   s3: make reading metadata more reliable to work around eventual
        consistency problems
    -   s3: strip trailing / from ListDir()
    -   swift: return directories without / in ListDir
-   v1.04 - 2014-07-21
    -   google cloud storage: Fix crash on Update
-   v1.03 - 2014-07-20
    -   swift, s3, dropbox: fix updated files being marked as corrupted
    -   Make compile with go 1.1 again
-   v1.02 - 2014-07-19
    -   Implement Dropbox remote
    -   Implement Google Cloud Storage remote
    -   Verify Md5sums and Sizes after copies
    -   Remove times from "ls" command - lists sizes only
    -   Add add "lsl" - lists times and sizes
    -   Add "md5sum" command
-   v1.01 - 2014-07-04
    -   drive: fix transfer of big files using up lots of memory
-   v1.00 - 2014-07-03
    -   drive: fix whole second dates
-   v0.99 - 2014-06-26
    -   Fix --dry-run not working
    -   Make compatible with go 1.1
-   v0.98 - 2014-05-30
    -   s3: Treat missing Content-Length as 0 for some ceph
        installations
    -   rclonetest: add file with a space in
-   v0.97 - 2014-05-05
    -   Implement copying of single files
    -   s3 & swift: support paths inside containers/buckets
-   v0.96 - 2014-04-24
    -   drive: Fix multiple files of same name being created
    -   drive: Use o.Update and fs.Put to optimise transfers
    -   Add version number, -V and --version
-   v0.95 - 2014-03-28
    -   rclone.org: website, docs and graphics
    -   drive: fix path parsing
-   v0.94 - 2014-03-27
    -   Change remote format one last time
    -   GNU style flags
-   v0.93 - 2014-03-16
    -   drive: store token in config file
    -   cross compile other versions
    -   set strict permissions on config file
-   v0.92 - 2014-03-15
    -   Config fixes and --config option
-   v0.91 - 2014-03-15
    -   Make config file
-   v0.90 - 2013-06-27
    -   Project named rclone
-   v0.00 - 2012-11-18
    -   Project started


Bugs and Limitations

Empty directories are left behind / not created

With remotes that have a concept of directory, eg Local and Drive, empty
directories may be left behind, or not created when one was expected.

This is because rclone doesn't have a concept of a directory - it only
works on objects. Most of the object storage systems can't actually
store a directory so there is nowhere for rclone to store anything about
directories.

You can work round this to some extent with thepurge command which will
delete everything under the path, INLUDING empty directories.

This may be fixed at some point in Issue #100

Directory timestamps aren't preserved

For the same reason as the above, rclone doesn't have a concept of a
directory - it only works on objects, therefore it can't preserve the
timestamps of directories.


Frequently Asked Questions

Do all cloud storage systems support all rclone commands

Yes they do. All the rclone commands (eg sync, copy etc) will work on
all the remote storage systems.

Can I copy the config from one machine to another

Sure! Rclone stores all of its config in a single file. If you want to
find this file, the simplest way is to run rclone -h and look at the
help for the --config flag which will tell you where it is.

See the remote setup docs for more info.

How do I configure rclone on a remote / headless box with no browser?

This has now been documented in its own remote setup page.

Can rclone sync directly from drive to s3

Rclone can sync between two remote cloud storage systems just fine.

Note that it effectively downloads the file and uploads it again, so the
node running rclone would need to have lots of bandwidth.

The syncs would be incremental (on a file by file basis).

Eg

    rclone sync drive:Folder s3:bucket

Using rclone from multiple locations at the same time

You can use rclone from multiple places at the same time if you choose
different subdirectory for the output, eg

    Server A> rclone sync /tmp/whatever remote:ServerA
    Server B> rclone sync /tmp/whatever remote:ServerB

If you sync to the same directory then you should use rclone copy
otherwise the two rclones may delete each others files, eg

    Server A> rclone copy /tmp/whatever remote:Backup
    Server B> rclone copy /tmp/whatever remote:Backup

The file names you upload from Server A and Server B should be different
in this case, otherwise some file systems (eg Drive) may make
duplicates.

Why doesn't rclone support partial transfers / binary diffs like rsync?

Rclone stores each file you transfer as a native object on the remote
cloud storage system. This means that you can see the files you upload
as expected using alternative access methods (eg using the Google Drive
web interface). There is a 1:1 mapping between files on your hard disk
and objects created in the cloud storage system.

Cloud storage systems (at least none I've come across yet) don't support
partially uploading an object. You can't take an existing object, and
change some bytes in the middle of it.

It would be possible to make a sync system which stored binary diffs
instead of whole objects like rclone does, but that would break the 1:1
mapping of files on your hard disk to objects in the remote cloud
storage system.

All the cloud storage systems support partial downloads of content, so
it would be possible to make partial downloads work. However to make
this work efficiently this would require storing a significant amount of
metadata, which breaks the desired 1:1 mapping of files to objects.

Can rclone do bi-directional sync?

No, not at present. rclone only does uni-directional sync from A -> B.
It may do in the future though since it has all the primitives - it just
requires writing the algorithm to do it.

Can I use rclone with an HTTP proxy?

Yes. rclone will use the environment variables HTTP_PROXY, HTTPS_PROXY
and NO_PROXY, similar to cURL and other programs.

HTTPS_PROXY takes precedence over HTTP_PROXY for https requests.

The environment values may be either a complete URL or a "host[:port]",
in which case the "http" scheme is assumed.

The NO_PROXY allows you to disable the proxy for specific hosts. Hosts
must be comma separated, and can contain domains or parts. For instance
"foo.com" also matches "bar.foo.com".

Rclone gives x509: failed to load system roots and no roots provided error

This means that rclone can't file the SSL root certificates. Likely you
are running rclone on a NAS with a cut-down Linux OS, or possibly on
Solaris.

Rclone (via the Go runtime) tries to load the root certificates from
these places on Linux.

    "/etc/ssl/certs/ca-certificates.crt", // Debian/Ubuntu/Gentoo etc.
    "/etc/pki/tls/certs/ca-bundle.crt",   // Fedora/RHEL
    "/etc/ssl/ca-bundle.pem",             // OpenSUSE
    "/etc/pki/tls/cacert.pem",            // OpenELEC

So doing something like this should fix the problem. It also sets the
time which is important for SSL to work properly.

    mkdir -p /etc/ssl/certs/
    curl -o /etc/ssl/certs/ca-certificates.crt https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
    ntpclient -s -h pool.ntp.org

Note that you may need to add the --insecure option to the curl command
line if it doesn't work without.

    curl --insecure -o /etc/ssl/certs/ca-certificates.crt https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt

Rclone gives Failed to load config file: function not implemented error

Likely this means that you are running rclone on Linux version not
supported by the go runtime, ie earlier than version 2.6.23.

See the system requirements section in the go install docs for full
details.

All my uploaded docx/xlsx/pptx files appear as archive/zip

This is caused by uploading these files from a Windows computer which
hasn't got the Microsoft Office suite installed. The easiest way to fix
is to install the Word viewer and the Microsoft Office Compatibility
Pack for Word, Excel, and PowerPoint 2007 and later versions' file
formats

tcp lookup some.domain.com no such host

This happens when rclone cannot resolve a domain. Please check that your
DNS setup is generally working, e.g.

    # both should print a long list of possible IP addresses
    dig www.googleapis.com          # resolve using your default DNS
    dig www.googleapis.com @8.8.8.8 # resolve with Google's DNS server

If you are using systemd-resolved (default on Arch Linux), ensure it is
at version 233 or higher. Previous releases contain a bug which causes
not all domains to be resolved properly.


License

This is free software under the terms of MIT the license (check the
COPYING file included with the source code).

    Copyright (C) 2012 by Nick Craig-Wood https://www.craig-wood.com/nick/

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.


Authors

-   Nick Craig-Wood nick@craig-wood.com


Contributors

-   Alex Couper amcouper@gmail.com
-   Leonid Shalupov leonid@shalupov.com shalupov@diverse.org.ru
-   Shimon Doodkin helpmepro1@gmail.com
-   Colin Nicholson colin@colinn.com
-   Klaus Post klauspost@gmail.com
-   Sergey Tolmachev tolsi.ru@gmail.com
-   Adriano Aurélio Meirelles adriano@atinge.com
-   C. Bess cbess@users.noreply.github.com
-   Dmitry Burdeev dibu28@gmail.com
-   Joseph Spurrier github@josephspurrier.com
-   Björn Harrtell bjorn@wololo.org
-   Xavier Lucas xavier.lucas@corp.ovh.com
-   Werner Beroux werner@beroux.com
-   Brian Stengaard brian@stengaard.eu
-   Jakub Gedeon jgedeon@sofi.com
-   Jim Tittsler jwt@onjapan.net
-   Michal Witkowski michal@improbable.io
-   Fabian Ruff fabian.ruff@sap.com
-   Leigh Klotz klotz@quixey.com
-   Romain Lapray lapray.romain@gmail.com
-   Justin R. Wilson jrw972@gmail.com
-   Antonio Messina antonio.s.messina@gmail.com
-   Stefan G. Weichinger office@oops.co.at
-   Per Cederberg cederberg@gmail.com
-   Radek Šenfeld rush@logic.cz
-   Fredrik Fornwall fredrik@fornwall.net
-   Asko Tamm asko@deekit.net
-   xor-zz xor@gstocco.com
-   Tomasz Mazur tmazur90@gmail.com
-   Marco Paganini paganini@paganini.net
-   Felix Bünemann buenemann@louis.info
-   Durval Menezes jmrclone@durval.com
-   Luiz Carlos Rumbelsperger Viana maxd13_luiz_carlos@hotmail.com
-   Stefan Breunig stefan-github@yrden.de
-   Alishan Ladhani ali-l@users.noreply.github.com
-   0xJAKE 0xJAKE@users.noreply.github.com
-   Thibault Molleman thibaultmol@users.noreply.github.com
-   Scott McGillivray scott.mcgillivray@gmail.com
-   Bjørn Erik Pedersen bjorn.erik.pedersen@gmail.com
-   Lukas Loesche lukas@mesosphere.io
-   emyarod allllaboutyou@gmail.com
-   T.C. Ferguson tcf909@gmail.com
-   Brandur brandur@mutelight.org
-   Dario Giovannetti dev@dariogiovannetti.net
-   Károly Oláh okaresz@aol.com
-   Jon Yergatian jon@macfanatic.ca
-   Jack Schmidt github@mowsey.org
-   Dedsec1 Dedsec1@users.noreply.github.com
-   Hisham Zarka hzarka@gmail.com
-   Jérôme Vizcaino jerome.vizcaino@gmail.com
-   Mike Tesch mjt6129@rit.edu
-   Marvin Watson marvwatson@users.noreply.github.com
-   Danny Tsai danny8376@gmail.com
-   Yoni Jah yonjah+git@gmail.com yonjah+github@gmail.com
-   Stephen Harris github@spuddy.org
-   Ihor Dvoretskyi ihor.dvoretskyi@gmail.com
-   Jon Craton jncraton@gmail.com
-   Hraban Luyat hraban@0brg.net
-   Michael Ledin mledin89@gmail.com
-   Martin Kristensen me@azgul.com
-   Too Much IO toomuchio@users.noreply.github.com
-   Anisse Astier anisse@astier.eu
-   Zahiar Ahmed zahiar@live.com
-   Igor Kharin igorkharin@gmail.com
-   Bill Zissimopoulos billziss@navimatics.com
-   Bob Potter bobby.potter@gmail.com
-   Steven Lu tacticalazn@gmail.com
-   Sjur Fredriksen sjurtf@ifi.uio.no
-   Ruwbin hubus12345@gmail.com
-   Fabian Möller fabianm88@gmail.com
-   Edward Q. Bridges github@eqbridges.com
-   Vasiliy Tolstov v.tolstov@selfip.ru
-   Harshavardhana harsha@minio.io
-   sainaen sainaen@gmail.com
-   gdm85 gdm85@users.noreply.github.com
-   Yaroslav Halchenko debian@onerussian.com
-   John Papandriopoulos jpap@users.noreply.github.com
-   Zhiming Wang zmwangx@gmail.com
-   Andy Pilate cubox@cubox.me
-   Oliver Heyme olihey@googlemail.com
-   wuyu wuyu@yunify.com
-   Andrei Dragomir adragomi@adobe.com
-   Christian Brüggemann mail@cbruegg.com
-   Alex McGrath Kraak amkdude@gmail.com
-   bpicode bjoern.pirnay@googlemail.com
-   Daniel Jagszent daniel@jagszent.de
-   Josiah White thegenius2009@gmail.com
-   Ishuah Kariuki kariuki@ishuah.com ishuah91@gmail.com
-   Jan Varho jan@varho.org
-   Girish Ramakrishnan girish@cloudron.io
-   LingMan LingMan@users.noreply.github.com
-   Jacob McNamee jacobmcnamee@gmail.com



CONTACT THE RCLONE PROJECT


Forum

Forum for general discussions and questions:

-   https://forum.rclone.org


Gitub project

The project website is at:

-   https://github.com/ncw/rclone

There you can file bug reports, ask for help or contribute pull
requests.


Google+

Rclone has a Google+ page which announcements are posted to

-   Google+ page for general comments


Twitter

You can also follow me on twitter for rclone announcments

-   [@njcw](https://twitter.com/njcw)


Email

Or if all else fails or you want to ask something private or
confidential email Nick Craig-Wood
