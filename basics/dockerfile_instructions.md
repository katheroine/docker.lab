# Dockerfile instructions

1. [`FROM`](#from)
2. [`RUN`](#run)
3. [`ADD`](#add)
4. [`COPY`](#copy)
5. [`VOLUME`](#volume)
6. [`WORKDIR`](#workdir)
7. [`USER`](#user)
8. [`EXPOSE`](#expose)
9. [`ARG`](#arg)
10. [`ENV`](#env)
11. [`CMD`](#cmd)

## All Dockerfile instructions

The Dockerfile supports the following instructions:

| Instruction                                                                       | Description                                                 |
|-----------------------------------------------------------------------------------|-------------------------------------------------------------|
| [ADD](https://docs.docker.com/reference/dockerfile/#add)                          | Add local or remote files and directories.                  |
| [ARG](https://docs.docker.com/reference/dockerfile/#arg)                          | Use build-time variables.                                   |
| [CMD](https://docs.docker.com/reference/dockerfile/#cmd)                          | Specify default commands.                                   |
| [COPY](https://docs.docker.com/reference/dockerfile/#copy)                        | Copy files and directories.                                 |
| [ENTRYPOINT](https://docs.docker.com/reference/dockerfile/#entrypoint)            | Specify default executable.                                 |
| [ENV](https://docs.docker.com/reference/dockerfile/#env)                          | Set environment variables.                                  |
| [EXPOSE](https://docs.docker.com/reference/dockerfile/#expose)                    | Describe which ports your application is listening on.      |
| [FROM](https://docs.docker.com/reference/dockerfile/#from)                        | Create a new build stage from a base image.                 |
| [HEALTHCHECK](https://docs.docker.com/reference/dockerfile/#healthcheck)          | Check a container's health on startup.                      |
| [LABEL](https://docs.docker.com/reference/dockerfile/#label)                      | Add metadata to an image.                                   |
| [MAINTAINER](https://docs.docker.com/reference/dockerfile/#maintainer-deprecated) | Specify the author of an image.                             |
| [ONBUILD](https://docs.docker.com/reference/dockerfile/#onbuild)                  | Specify instructions for when the image is used in a build. |
| [RUN](https://docs.docker.com/reference/dockerfile/#run)                          | Execute build commands.                                     |
| [SHELL](https://docs.docker.com/reference/dockerfile/#shell)                      | Set the default shell of an image.                          |
| [STOPSIGNAL](https://docs.docker.com/reference/dockerfile/#stopsignal)            | Specify the system call signal for exiting a container.     |
| [USER](https://docs.docker.com/reference/dockerfile/#user)                        | Set user and group ID.                                      |
| [VOLUME](https://docs.docker.com/reference/dockerfile/#volume)                    | Create volume mounts.                                       |
| [WORKDIR](https://docs.docker.com/reference/dockerfile/#workdir)                  | Change working directory.                                   |

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#overview)

## [`FROM`](https://docs.docker.com/reference/dockerfile/#from)

The `FROM` instruction initializes a new build stage and sets the base image for subsequent instructions. As such, a valid Dockerfile must start with a `FROM` instruction. The image can be any valid image.

```dockerfile
FROM [--platform=<platform>] <image> [AS <name>]
```

Or

```dockerfile
FROM [--platform=<platform>] <image>[:<tag>] [AS <name>]
```

Or

```dockerfile
FROM [--platform=<platform>] <image>[@<digest>] [AS <name>]
```

`ARG` is the only instruction that may precede `FROM` in the Dockerfile.

`FROM` can appear multiple times within a single Dockerfile to create multiple images or use one build stage as a dependency for another. Simply make a note of the last image ID output by the commit before each new `FROM` instruction. Each `FROM` instruction clears any state created by previous instructions.

Optionally a name can be given to a new build stage by adding `AS` name to the `FROM` instruction. The name can be used in subsequent `FROM <name>`, `COPY --from=<name>`, and `RUN --mount=type=bind,from=<name>` instructions to refer to the image built in this stage.

The tag or digest values are optional. If you omit either of them, the builder assumes a latest tag by default. The builder returns an error if it can't find the tag value.

The optional `--platform` flag can be used to specify the platform of the image in case `FROM` references a multi-platform image. For example, `linux/amd64`, `linux/arm64`, or `windows/amd64`. By default, the target platform of the build request is used. Global build arguments can be used in the value of this flag, for example automatic platform ARGs allow you to force a stage to native build platform (`--platform=$BUILDPLATFORM`), and use it to cross-compile to the target platform inside the stage.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#from)

**Examples**

* Simple image

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/from-simple/Dockerfile)

```dockerfile
FROM busybox

```

```console
$ docker build -t from-simple .
[+] Building 2.3s (5/5) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 50B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/busybox:latest                                                                                                                                                                                                            2.1s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/1] FROM docker.io/library/busybox:latest@sha256:ab33eacc8251e3807b85bb6dba570e4698c3998eca6f0fc2ccb60575a563ea74                                                                                                                                               0.0s
 => exporting to image                                                                                                                                                                                                                                                       0.0s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:9289c93df9f65e55ca1e5f9a56ac7c4fac1e7dd00f356bcc29b6bad93cc94311                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/from-simple                                                                                                                                                                                                                               0.0s
```

```console
$ docker images
REPOSITORY    TAG       IMAGE ID       CREATED         SIZE
from-simple   latest    9289c93df9f6   11 months ago   4.43MB
```

## [`RUN`](https://docs.docker.com/reference/dockerfile/#run)

The `RUN` instruction will execute any commands *to create a new layer on top of the current image*. The added layer is used in the next step in the Dockerfile.

`RUN` has two forms.

* **Shell form**

```dockerfile
RUN [OPTIONS] <command> ...
```

* **Exec form**

```dockerfile
RUN [OPTIONS] [ "<command>", ... ]
```

The *shell form* is most commonly used, and lets you break up longer instructions into multiple lines, either using newline escapes, or with heredocs:

The shell form is most commonly used, and lets you break up longer instructions into multiple lines, either using newline escapes, or with heredocs:

```dockerfile
RUN <<EOF
apt-get update
apt-get install -y curl
EOF
```

**Options**

| Option                                                                       | Description                                                            |
|------------------------------------------------------------------------------|------------------------------------------------------------------------|
| [`--device`](https://docs.docker.com/reference/dockerfile/#run---device)     | allows build to request CDI devices to be available to the build step  |
| [`--mount`](https://docs.docker.com/reference/dockerfile/#run---mount)       | allows you to create filesystem mounts that the build can access       |
| [`--network`](https://docs.docker.com/reference/dockerfile/#run---network)   | allows control over which networking environment the command is run in |
| [`--security`](https://docs.docker.com/reference/dockerfile/#run---security) | allows to run flows requiring elevated privileges (e.g. containerd)    |

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#run)

**Examples**

* Simple layer

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/run-simple/Dockerfile)

```dockerfile
FROM ubuntu

RUN apt update && apt -y install lynx

```

```console
$ docker build -t run-simple .
[+] Building 32.2s (6/6) FINISHED                                                                                                                                                                                                                                  docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s => => transferring dockerfile: 88B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             0.5s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/2] FROM docker.io/library/ubuntu:latest@sha256:9cbed754112939e914291337b5e554b07ad7c392491dba6daf25eef1332a22e8                                                                                                                                                0.0s
 => [2/2] RUN apt update && apt install -y lynx                                                                                                                                                                                                                             28.8s
 => exporting to image                                                                                                                                                                                                                                                       2.7s
 => => exporting layers                                                                                                                                                                                                                                                      2.7s
 => => writing image sha256:9a52c06cb2a5b648054b6ec833ecf0aa98437630136b4addb5e562103d48a589                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/run-simple
 ```

 ```console
 $ docker images
REPOSITORY   TAG       IMAGE ID       CREATED        SIZE
run-simple   latest    438339b0c3ab   13 hours ago   194MB
```

Running container created from this image place us into the container context, and using the lynx package will be possible.

```console
$ docker run -it --name run-fast run-simple
root@2ed3cd9c1484:/# lynx https://katheroine.github.io/docker.lab/
root@2ed3cd9c1484:/#
```

## [ADD](https://docs.docker.com/reference/dockerfile/#add)

The `ADD` instruction copies new files or directories from `<src>` and adds them to the filesystem of the image at the path `<dest>`. Files and directories can be copied from the build context, a remote URL, or a Git repository.

ADD has two forms. The exec form is required for paths containing whitespace.

* **Shell form**

```dockerfile
ADD [OPTIONS] <src> ... <dest>
```

* **Exec form**

```dockerfile
ADD [OPTIONS] ["<src>", ... "<dest>"]
```

The `ADD` and `COPY` instructions are functionally similar, but serve slightly different purposes.

**Options**

| Option                                                                             | Description                                                         |
|------------------------------------------------------------------------------------|---------------------------------------------------------------------|
| [--keep-git-dir](https://docs.docker.com/reference/dockerfile/#add---keep-git-dir) | lets you preserve the `.git` directory                              |
| [--checksum](https://docs.docker.com/reference/dockerfile/#add---checksum)         | lets you verify the checksum of a remote resource                   |
| [--chown](https://docs.docker.com/reference/dockerfile/#add---chown---chmod)       | lets you define the owner and groups                                |
| [--chmod](https://docs.docker.com/reference/dockerfile/#add---chown---chmod)       | lets you define the permission bits                                 |
| [--link](https://docs.docker.com/reference/dockerfile/#add---link)                 | lets you copy your source files into an empty destination directory |
| [--exclude](https://docs.docker.com/reference/dockerfile/#add---exclude)           | lets you specify a path expression for files to be excluded         |


***Source***

You can specify multiple source files or directories with `ADD`. The last argument must always be the destination. For example, to add two files, `file1.txt` and `file2.txt`, from the build context to `/usr/src/things/` in the build container:

```dockerfile
ADD file1.txt file2.txt /usr/src/things/
```

If you specify multiple source files, either directly or using a wildcard, then the destination must be a directory (must end with a slash `/`).

To add files from a remote location, you can specify a URL or the address of a Git repository as the source. For example:

```dockerfile
ADD https://example.com/archive.zip /usr/src/things/
ADD git@github.com:user/repo.git /usr/src/things/
```

BuildKit detects the type of `<src>` and processes it accordingly.

* If `<src>` is a local file or directory, the contents of the directory are copied to the specified destination.
* If `<src>` is a local tar archive, it is decompressed and extracted to the specified destination.
* If `<src>` is a URL, the contents of the URL are downloaded and placed at the specified destination.
* If `<src>` is a Git repository, the repository is cloned to the specified destination.

*Adding files from the build context*

Any relative or local path that doesn't begin with a `http://`, `https://`, or `git@` protocol prefix is considered a local file path. The local file path is relative to the build context. For example, if the build context is the current directory, `ADD file.txt /` adds the file at `./file.txt` to the root of the filesystem in the build container.

Specifying a source path with a leading slash or one that navigates outside the build context, such as `ADD ../something /something`, automatically removes any parent directory navigation (`../`). Trailing slashes in the source path are also disregarded, making `ADD something/ /something` equivalent to `ADD something /something`.

If the source is a directory, the contents of the directory are copied, including filesystem metadata. The directory itself isn't copied, only its contents. If it contains subdirectories, these are also copied, and merged with any existing directories at the destination. Any conflicts are resolved in favor of the content being added, on a file-by-file basis, except if you're trying to copy a directory onto an existing file, in which case an error is raised.

If the source is a file, the file and its metadata are copied to the destination. File permissions are preserved. If the source is a file and a directory with the same name exists at the destination, an error is raised.

If you pass a Dockerfile through `stdin` to the build (`docker build - < Dockerfile`), there is *no build context*. In this case, you can only use the `ADD` instruction to copy remote files. You can also pass a `tar` archive through `stdin`: (`docker build - < archive.tar`), the Dockerfile at the root of the archive and the rest of the archive will be used as the context of the build.

*Pattern matching*

For local files, each `<src>` may contain wildcards and matching will be done using Go's `filepath.Match` rules.

For example, to add all files and directories in the root of the build context ending with `.png`:

```dockerfile
ADD *.png /dest/
```

In the following example, `?` is a single-character wildcard, matching e.g. `index.js` and `index.ts`.

```dockerfile
ADD index.?s /dest/
```

When adding files or directories that contain special characters (such as `[` and `]`), you need to escape those paths following the Golang rules to prevent them from being treated as a matching pattern. For example, to add a file named `arr[0].txt`, use the following;

```dockerfile
ADD arr[[]0].txt /dest/
```

*Adding local tar archives*

When using a local tar archive as the source for `ADD`, and the archive is in a recognized compression format (`gzip`, `bzip2` or `xz`, or uncompressed), the archive is decompressed and extracted into the specified destination. Only local tar archives are extracted. If the tar archive is a remote URL, the archive is not extracted, but downloaded and placed at the destination.

When a directory is extracted, it has the same behavior as `tar -x`. The result is the union of:

* Whatever existed at the destination path;
* The contents of the source tree, with conflicts resolved in favor of the content being added, on a file-by-file basis.

Whether a file is identified as a recognized compression format or not is done solely based on the contents of the file, not the name of the file. For example, if an empty file happens to end with `.tar.gz` this isn't recognized as a compressed file and doesn't generate any kind of decompression error message, rather the file will simply be copied to the destination.

*Adding files from a URL*

In the case where source is a remote file URL, the destination will have permissions of `600`. If the HTTP response contains a `Last-Modified` header, the timestamp from that header will be used to set the `mtime` on the destination file. However, like any other file processed during an `ADD`, mtime isn't included in the determination of whether or not the file has changed and the cache should be updated.

If the destination ends with a trailing slash, then the filename is inferred from the URL path. For example, `ADD http://example.com/foobar /` would create the file `/foobar`. The URL must have a nontrivial path so that an appropriate filename can be discovered (`http://example.com` doesn't work).

If the destination doesn't end with a trailing slash, the destination path becomes the filename of the file downloaded from the URL. For example, `ADD http://example.com/foo /bar` creates the file `/bar`.

If your URL files are protected using authentication, you need to use RUN wget, RUN curl or use another tool from within the container as the ADD instruction doesn't support authentication.

*Adding files from a Git repository*

To use a Git repository as the source for `ADD`, you can reference the repository's HTTP or SSH address as the source. The repository is cloned to the specified destination in the image.

```dockerfile
ADD https://github.com/user/repo.git /mydir/
```

You can use URL fragments to specify a specific branch, tag, commit, or subdirectory. For example, to add the docs directory of the v0.14.1 tag of the buildkit repository:

```dockerfile
ADD git@github.com:moby/buildkit.git#v0.14.1:docs /buildkit-docs
```

When adding from a Git repository, the permissions bits for files are `644`. If a file in the repository has the executable bit set, it will have permissions set to 755. Directories have permissions set to `755`.

When using a Git repository as the source, the repository must be accessible from the build context. To add a repository via SSH, whether public or private, you must pass an SSH key for authentication. For example, given the following Dockerfile:

```dockerfile
# syntax=docker/dockerfile:1
FROM alpine
ADD git@git.example.com:foo/bar.git /bar
```

To build this Dockerfile, pass the `--ssh` flag to the docker build to mount the SSH agent socket to the build. For example:

```
docker build --ssh default .
```

For more information about building with secrets, see Build secrets.

***Destination***

If the destination path begins with a forward slash, it's interpreted as an absolute path, and the source files are copied into the specified destination relative to the root of the current build stage.

```dockerfile
# create /abs/test.txt
ADD test.txt /abs/
```

Trailing slashes are significant. For example, `ADD test.txt /abs` creates a file at `/abs`, whereas `ADD test.txt /abs/` creates `/abs/test.txt`.

If the destination path doesn't begin with a leading slash, it's interpreted as relative to the working directory of the build container.

```dockerfile
WORKDIR /usr/src/app
# create /usr/src/app/rel/test.txt
ADD test.txt rel/
```

If destination doesn't exist, it's created, along with all missing directories in its path.

If the source is a file, and the destination doesn't end with a trailing slash, the source file will be written to the destination path as a file.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#add)

**Examples**

* Simple file adding

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/add-simple/Dockerfile)

```dockerfile
FROM debian

ADD file.txt /home/me/

```

```console
$ docker build -t add-simple .
[+] Building 15.8s (8/8) FINISHED                                                                                                                                                                                                                                  docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 73B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                                                                                                                                             1.8s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => [internal] load build context                                                                                                                                                                                                                                            0.1s
 => => transferring context: 119B                                                                                                                                                                                                                                            0.0s
 => [1/2] FROM docker.io/library/debian:latest@sha256:833c135acfe9521d7a0035a296076f98c182c542a2b6b5a0fd7063d355d696be                                                                                                                                                      13.2s
 => => resolve docker.io/library/debian:latest@sha256:833c135acfe9521d7a0035a296076f98c182c542a2b6b5a0fd7063d355d696be                                                                                                                                                       0.0s
 => => sha256:833c135acfe9521d7a0035a296076f98c182c542a2b6b5a0fd7063d355d696be 8.93kB / 8.93kB                                                                                                                                                                               0.0s
 => => sha256:56b68c54f22562e5931513fabfc38a23670faf16bbe82f2641d8a2c836ea30fc 1.02kB / 1.02kB                                                                                                                                                                               0.0s
 => => sha256:999ffdddc1528999603ade1613e0d336874d34448a74db8f981c6fae4db91ad7 451B / 451B                                                                                                                                                                                   0.0s
 => => sha256:15b1d8a5ff03aeb0f14c8d39a60a73ef22f656550bfa1bb90d1850f25a0ac0fa 49.28MB / 49.28MB                                                                                                                                                                             5.2s
 => => extracting sha256:15b1d8a5ff03aeb0f14c8d39a60a73ef22f656550bfa1bb90d1850f25a0ac0fa                                                                                                                                                                                    7.5s
 => [2/2] ADD file.txt /home/me/                                                                                                                                                                                                                                             0.6s
 => exporting to image                                                                                                                                                                                                                                                       0.1s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:800c41c2c1ad7de7722992b9fff24b758016a53947f85ff5945a7b2925551b6d                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/add-simple
```

```console
$ docker images
REPOSITORY   TAG       IMAGE ID       CREATED         SIZE
add-simple   latest    800c41c2c1ad   2 minutes ago   120MB
```

The destination directories from the path defined in the Dockerfie will be created if they don't exist.
This is important to finish th destination directories path with the `/` sign to prevent from copying source file `file.txt` as a destination file with name `me` in the `/home` directory.

```console
$ docker run -it --name add-single-file add-simple
root@22c4cf7a459b:/# ls /home/me/
file.txt
root@22c4cf7a459b:/# cat /home/me/file.txt
This is the sample file purposed to be placed into the filesystem of the container.
root@22c4cf7a459b:/#
```

## [COPY](https://docs.docker.com/reference/dockerfile/#copy)

The `COPY` instruction copies new files or directories from `<src>` and adds them to the filesystem of the image at the path `<dest>`. Files and directories can be copied from the build context, build stage, named context, or an image.

COPY has two forms. The exec form is required for paths containing whitespace.

* **Shell form**

```dockerfile
COPY [OPTIONS] <src> ... <dest>
```

* **Exec form**

```dockerfile
COPY [OPTIONS] ["<src>", ... "<dest>"]
```

The `ADD` and `COPY` instructions are functionally similar, but serve slightly different purposes.

**Options**

| Option                                                                        | Description                                                                  |
|-------------------------------------------------------------------------------|------------------------------------------------------------------------------|
| [--from](https://docs.docker.com/reference/dockerfile/#copy---from)           | lets you copy files from an image, a build stage, or a named context instead |
| [--chown](https://docs.docker.com/reference/dockerfile/#copy---chown---chmod) | lets you define the owner and groups                                         |
| [--chmod](https://docs.docker.com/reference/dockerfile/#copy---chown---chmod) | lets you define the permission bits                                          |
| [--link](https://docs.docker.com/reference/dockerfile/#copy---link)           | lets you copy your source files into an empty destination directory          |
| [--parents](https://docs.docker.com/reference/dockerfile/#copy---parents)     | preserves parent directories for `src` entries                               |
| [--exclude](https://docs.docker.com/reference/dockerfile/#copy---exclude)     | lets you specify a path expression for files to be excluded                  |

***Source***

You can specify multiple source files or directories with `COPY`. The last argument must always be the destination. For example, to copy two files, `file1.txt` and `file2.txt`, from the build context to `/usr/src/things/` in the build container:

```dockerfile
COPY file1.txt file2.txt /usr/src/things/
```

If you specify multiple source files, either directly or using a wildcard, then the destination must be a directory (must end with a slash `/`).

`COPY` accepts a flag `--from=<name>` that lets you specify the source location to be a build stage, context, or image. The following example copies files from a stage named `build`:

```dockerfile
FROM golang AS build
WORKDIR /app
RUN --mount=type=bind,target=. go build -o /myapp ./cmd

COPY --from=build /myapp /usr/bin/
```

*Copying from the build context*

When copying source files from the build context, paths are interpreted as relative to the root of the context.

Specifying a source path with a leading slash or one that navigates outside the build context, such as `COPY ../something /something`, automatically removes any parent directory navigation (`../`). Trailing slashes in the source path are also disregarded, making `COPY something/ /something` equivalent to `COPY something /something`.

If the source is a directory, the contents of the directory are copied, including filesystem metadata. The directory itself isn't copied, only its contents. If it contains subdirectories, these are also copied, and merged with any existing directories at the destination. Any conflicts are resolved in favor of the content being added, on a file-by-file basis, except if you're trying to copy a directory onto an existing file, in which case an error is raised.

If the source is a file, the file and its metadata are copied to the destination. File permissions are preserved. If the source is a file and a directory with the same name exists at the destination, an error is raised.

If you pass a Dockerfile through `stdin` to the build (`docker build - < Dockerfile`), there is no build context. In this case, you can only use the `COPY` instruction to copy files from other stages, named contexts, or images, using the `--from` flag. You can also pass a tar archive through `stdin`: (`docker build - < archive.tar`), the Dockerfile at the root of the archive and the rest of the archive will be used as the context of the build.

When using a Git repository as the build context, the permissions bits for copied files are `644`. If a file in the repository has the executable bit set, it will have permissions set to `755`. Directories have permissions set to `755`.

*Pattern matching*

For local files, each `<src>` may contain wildcards and matching will be done using Go's `filepath.Match` rules.

For example, to add all files and directories in the root of the build context ending with `.png`:

```dockerfile
COPY *.png /dest/
```

In the following example, `?` is a single-character wildcard, matching e.g. `index.js` and `index.ts`.

```dockerfile
COPY index.?s /dest/
```

When adding files or directories that contain special characters (such as `[` and `]`), you need to escape those paths following the Golang rules to prevent them from being treated as a matching pattern. For example, to add a file named `arr[0].txt`, use the following;

```dockerfile
COPY arr[[]0].txt /dest/
```

***Destination***

If the destination path begins with a forward slash, it's interpreted as an absolute path, and the source files are copied into the specified destination relative to the root of the current build stage.

```dockerfile
# create /abs/test.txt
COPY test.txt /abs/
```

Trailing slashes are significant. For example, `COPY test.txt /ab`s creates a file at `/abs`, whereas `COPY test.txt /abs/ creates /abs/test.txt`.

If the destination path doesn't begin with a leading slash, it's interpreted as relative to the working directory of the build container.

```dockerfile
WORKDIR /usr/src/app
# create /usr/src/app/rel/test.txt
COPY test.txt rel/
```

If destination doesn't exist, it's created, along with all missing directories in its path.

If the source is a file, and the destination doesn't end with a trailing slash, the source file will be written to the destination path as a file.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#copy)

**Examples**

* Simple file copying

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/copy-simple/Dockerfile)

```dockerfile
FROM debian

COPY file.txt /home/me/

```

```console
$ docker build -t copy-simple .
[+] Building 2.5s (8/8) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.1s
 => => transferring dockerfile: 74B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                                                                                                                                             2.0s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => [internal] load build context                                                                                                                                                                                                                                            0.1s
 => => transferring context: 119B                                                                                                                                                                                                                                            0.0s
 => CACHED [1/2] FROM docker.io/library/debian:latest@sha256:833c135acfe9521d7a0035a296076f98c182c542a2b6b5a0fd7063d355d696be                                                                                                                                                0.0s
 => [2/2] COPY file.txt /home/me/                                                                                                                                                                                                                                            0.1s
 => exporting to image                                                                                                                                                                                                                                                       0.1s
 => => exporting layers                                                                                                                                                                                                                                                      0.1s
 => => writing image sha256:7896d7643d0f72c53f7f23ba0103f1d1ddddb0fa2cfdf1ebd4a03a4da733b4af                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/copy-simple
 ```

```console
$ docker images
REPOSITORY    TAG       IMAGE ID       CREATED         SIZE
copy-simple   latest    7896d7643d0f   2 minutes ago   120MB
```

The destination directories from the path defined in the Dockerfie will be created if they don't exist.
This is important to finish th destination directories path with the `/` sign to prevent from copying source file `file.txt` as a destination file with name `me` in the `/home` directory.

```console
$ docker run -it --name copy-single-file copy-simple
root@45ffd981dd5a:/# ls /home/me/
file.txt
root@45ffd981dd5a:/# cat /home/me/file.txt
This is the sample file purposed to be placed into the filesystem of the container.
root@45ffd981dd5a:/#
```

## [`VOLUME`](https://docs.docker.com/reference/dockerfile/#volume)

The `VOLUME` instruction creates a mount point with the specified name and marks it as holding externally mounted volumes from native host or other containers.

```dockerfile
VOLUME ["/data"]
```

The `VOLUME` instruction creates a mount point with the specified name and marks it as holding externally mounted volumes from native host or other containers. The value can be a JSON array, `VOLUME ["/var/log/"]`, or a plain string with multiple arguments, such as `VOLUME /var/log` or `VOLUME /var/log /var/db`.

The `docker run` command initializes the newly created volume with any data that exists at the specified location within the base image. For example, consider the following Dockerfile snippet:

```dockerfile
FROM ubuntu
RUN mkdir /myvol
RUN echo "hello world" > /myvol/greeting
VOLUME /myvol
```

This Dockerfile results in an image that causes `docker run` to create a new mount point at `/myvol` and copy the greeting file into the newly created volume.

***Notes about specifying volumes***

Keep the following things in mind about volumes in the Dockerfile.

* **Volumes on Windows-based containers**: When using Windows-based containers, the destination of a volume inside the container must be one of:
    * a non-existing or empty directory
    * a drive other than C:
* **Changing the volume from within the Dockerfile**: If any build steps change the data within the volume after it has been declared, those changes will be discarded when using the legacy builder. When using Buildkit, the changes will instead be kept.
* **JSON formatting**: The list is parsed as a JSON array. You must enclose words with double quotes (`"`) rather than single quotes (`'`).
* **The host directory is declared at container run-time**: The host directory (the mountpoint) is, by its nature, host-dependent. This is to preserve image portability, since a given host directory can't be guaranteed to be available on all hosts. For this reason, you can't mount a host directory from within the Dockerfile. The VOLUME instruction does not support specifying a host-dir parameter. You must specify the mountpoint when you create or run the container.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#volume)

**Examples**

* Simple directory creation

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/volume-simple/Dockerfile)

```dockerfile
FROM ubuntu
VOLUME /some_directory

```

```console
$ docker build -t volume-simple .
[+] Building 1.1s (5/5) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.1s
 => => transferring dockerfile: 71B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             0.9s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/1] FROM docker.io/library/ubuntu:latest@sha256:9cbed754112939e914291337b5e554b07ad7c392491dba6daf25eef1332a22e8                                                                                                                                                0.0s
 => exporting to image                                                                                                                                                                                                                                                       0.0s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:8f7058b4357e0d39939cbb3d3f0b63d75ef29bec89a73460ee9d8e33c57905af                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/volume-simple
```

```console
$ docker images
REPOSITORY      TAG       IMAGE ID       CREATED       SIZE
volume-simple   latest    8f7058b4357e   3 weeks ago   78.1MB
```

```console
$ docker run -it --name volume-simple-directory volume-simple
root@d575e3ff2078:/# ls
bin  boot  dev  etc  home  lib  lib64  media  mnt  opt  proc  root  run  sbin  some_directory  srv  sys  tmp  usr  var
root@d575e3ff2078:/# cd some_directory/
root@d575e3ff2078:/some_directory# pwd
/some_directory
root@d575e3ff2078:/some_directory#
```

## [`WORKDIR`](https://docs.docker.com/reference/dockerfile/#workdir)

The `WORKDIR` instruction sets the working directory for any `RUN`, `CMD`, `ENTRYPOINT`, `COPY` and `ADD` instructions that follow it in the Dockerfile.

```dockerfile
WORKDIR /path/to/workdir
```

If the WORKDIR doesn't exist, it will be created even if it's not used in any subsequent Dockerfile instruction.

The `WORKDIR` instruction can be used multiple times in a Dockerfile. If a relative path is provided, it will be relative to the path of the previous `WORKDIR` instruction. For example:

```dockerfile
WORKDIR /a
WORKDIR b
WORKDIR c
RUN pwd
```

The output of the final pwd command in this Dockerfile would be `/a/b/c`.

The `WORKDIR` instruction can resolve environment variables previously set using `ENV`. You can only use environment variables explicitly set in the Dockerfile. For example:

```dockerfile
ENV DIRPATH=/path
WORKDIR $DIRPATH/$DIRNAME
RUN pwd
```

The output of the final pwd command in this Dockerfile would be `/path/$DIRNAME`

If not specified, the default working directory is `/`. In practice, if you aren't building a Dockerfile from scratch (`FROM scratch`), the `WORKDIR` may likely be set by the base image you're using.

Therefore, to avoid unintended operations in unknown directories, it's best practice to set your WORKDIR explicitly.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#workdir)

**Examples**

* Simple workdir path change

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/workdir-simple/Dockerfile)

```dockerfile
FROM ubuntu
WORKDIR /home/here/we/are/

```

```console
$ docker build -t workdir-simple .
[+] Building 2.4s (7/7) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.1s
 => => transferring dockerfile: 77B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             1.9s
 => [auth] library/ubuntu:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/2] FROM docker.io/library/ubuntu:latest@sha256:9cbed754112939e914291337b5e554b07ad7c392491dba6daf25eef1332a22e8                                                                                                                                                0.0s
 => [2/2] WORKDIR /home/here/we/are/                                                                                                                                                                                                                                         0.1s
 => exporting to image                                                                                                                                                                                                                                                       0.1s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:bac1ffc926acdff44ea78784732aa365b6fb0cf2effa0ad980fec1c3a40af164                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/workdir-simple
```

```console
$ docker images
REPOSITORY       TAG       IMAGE ID       CREATED          SIZE
workdir-simple   latest    bac1ffc926ac   47 seconds ago   78.1MB
```

```console
$ docker run -it --name workdir-simple-path workdir-simple
root@1bb0404573f2:/home/here/we/are# pwd
/home/here/we/are
root@1bb0404573f2:/home/here/we/are#
```

## [`USER`](https://docs.docker.com/reference/dockerfile/#user)

The `USER` instruction sets the *user name* (or `UID`) and optionally the *user group* (or `GID`) to use as the default user and group for the remainder of the current stage.

```dockerfile
USER <user>[:<group>]
```

or

```dockerfile
USER UID[:GID]
```

The specified user is used for `RUN` instructions and at runtime, runs the relevant `ENTRYPOINT` and `CMD` commands.

Note that when specifying a group for the user, the user will have only the specified group membership. Any other configured group memberships will be ignored.

When the user doesn't have a primary group then the image (or the next instructions) will be run with the `root` group.

On Windows, the user must be created first if it's not a built-in account. This can be done with the net user command called as part of a Dockerfile.

```dockerfile
FROM microsoft/windowsservercore
# Create Windows user in the container
RUN net user /add patrick
# Set it for subsequent commands
USER patrick
```

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#user)

**Examples**

* Simple default user change

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/user-simple/Dockerfile)

```dockerfile
FROM debian
USER www-data

```

```console
$ docker build -t user-simple .
[+] Building 3.2s (6/6) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 63B                                                                                                                                                                                                                                          0.0s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                                                                                                                                             3.1s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/1] FROM docker.io/library/debian:latest@sha256:833c135acfe9521d7a0035a296076f98c182c542a2b6b5a0fd7063d355d696be                                                                                                                                                0.0s
 => exporting to image                                                                                                                                                                                                                                                       0.0s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:397456ba6cd229611e0ef0f10c7f616e6c5e3ac06d320a595f93b7addb00bcd4                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/user-simple
```

```console
$ docker images
REPOSITORY    TAG       IMAGE ID       CREATED      SIZE
user-simple   latest    af1a2210bcc9   7 days ago   120MB
```

```console
$ docker run -it --name user-simple-change user-simple
www-data@5c4093270ba6:/$ whoami
www-data
www-data@5c4093270ba6:/$
```

## [`EXPOSE`](https://docs.docker.com/reference/dockerfile/#expose)

The `EXPOSE` instruction informs Docker that the container listens on the specified network ports at runtime.

```dockerfile
EXPOSE <port> [<port>/<protocol>...]
```

You can specify whether the port listens on TCP or UDP, and the default is TCP if you don't specify a protocol.

*The `EXPOSE` instruction doesn't actually publish the port. It functions as a type of documentation* between the person who builds the image and the person who runs the container, about which ports are intended to be published. To publish the port when running the container, use the `-p` flag on docker run to publish and map one or more ports, or the `-P` flag to publish all exposed ports and map them to high-order ports.

By default, `EXPOSE` assumes TCP. You can also specify UDP:

```dockerfile
EXPOSE 80/udp
```

To expose on both TCP and UDP, include two lines:

```dockerfile
EXPOSE 80/tcp
EXPOSE 80/udp
```

In this case, if you use `-P` with docker run, the port will be exposed once for TCP and once for UDP. Remember that `-P` uses an ephemeral high-ordered host port on the host, so TCP and UDP doesn't use the same port.

Regardless of the `EXPOSE` settings, you can override them at runtime by using the `-p` flag. For example

```dockerfile
docker run -p 80:80/tcp -p 80:80/udp ...
```

To set up port redirection on the host system, see using the `-P` flag. The `docker network` command supports creating networks for communication among containers without the need to expose or publish specific ports, because the containers connected to the network can communicate with each other over any port. For detailed information, see the overview of this feature.

**Examples**

* Simple port redirection

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/expose-simple/Dockerfile)

```dockerfile
FROM ubuntu

COPY site.conf /etc/apache2/sites-available/
COPY index.html /var/www/hello/public/

RUN apt update && apt upgrade -y \
&& apt install -y apache2 \
&& a2dissite 000-default.conf && a2ensite site.conf

EXPOSE 80

CMD apachectl -D FOREGROUND

```

```console
$ docker build -t expose-simple .
[+] Building 106.4s (10/10) FINISHED                                                                                                                                                                                                                               docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 292B                                                                                                                                                                                                                                         0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             4.7s
 => [auth] library/ubuntu:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/4] FROM docker.io/library/ubuntu:latest@sha256:590e57acc18d58cd25d00254d4ca989bbfcd7d929ca6b521892c9c904c391f50                                                                                                                                                0.0s
 => [internal] load build context                                                                                                                                                                                                                                            0.0s
 => => transferring context: 60B                                                                                                                                                                                                                                             0.0s
 => [2/4] COPY site.conf /etc/apache2/sites-available/                                                                                                                                                                                                                       0.1s
 => [3/4] COPY index.html /var/www/hello/public/                                                                                                                                                                                                                             0.1s
 => [4/4] RUN apt update && apt upgrade -y && apt install -y apache2 && a2dissite 000-default.conf && a2ensite site.conf                                                                                                                                                    93.0s
 => exporting to image                                                                                                                                                                                                                                                       8.2s
 => => exporting layers                                                                                                                                                                                                                                                      8.1s
 => => writing image sha256:d559ec4f4fccb8e2218c7968922861c64ad127062427ed479bc1bff97eef6033                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/expose-simple                                                                                                                                                                                                                             0.0s
```

```console
$ docker images
REPOSITORY      TAG       IMAGE ID       CREATED          SIZE
expose-simple   latest    7b34736713ae   45 seconds ago   239MB
```

```console
$ docker run -d -p 8080:80/tcp --name expose-simple-tcp expose-simple
```

*`/etc/hosts` on the host*

```
127.0.0.1       hello.local
```

Running lynx browser on the host machine should show the simple page with `Hello, there!` text.

```console
$ lynx http://hello.local:8080
```

The same effect should be available with the address `http://localhost:8080`.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#expose)

## [`ARG`](https://docs.docker.com/reference/dockerfile/#arg)

The `ARG` instruction defines a variable that users can pass at build-time to the builder with the docker build command using the `--build-arg <varname>=<value>` flag.

```dockerfile
ARG <name>[=<default value>] [<name>[=<default value>]...]
```

*It isn't recommended to use build arguments for passing secrets such as user credentials, API tokens, etc.* Build arguments are visible in the docker history command and in max mode provenance attestations, which are attached to the image by default if you use the Buildx GitHub Actions and your GitHub repository is public.

Refer to the `RUN --mount=type=secret` section to learn about secure ways to use secrets when building images.

A Dockerfile may include one or more `ARG` instructions. For example, the following is a valid Dockerfile:

```dockerfile
FROM busybox
ARG user1
ARG buildno
# ...
```

***Default values***

An `ARG` instruction can optionally include a default value:

```dockerfile
FROM busybox
ARG user1=someuser
ARG buildno=1
# ...
```

If an `ARG `instruction has a default value and if there is no value passed at build-time, the builder uses the default.

***Scope***

An `ARG` variable comes into effect from the line on which it is declared in the Dockerfile. For example, consider this Dockerfile:

```dockerfile
FROM busybox
USER ${username:-some_user}
ARG username
USER $username
# ...
```

A user builds this file by calling:

```
docker build --build-arg username=what_user .
```

The `USER` instruction on line 2 evaluates to the `some_user` fallback, because the `username` variable is not yet declared.
The `username` variable is declared on line 3, and available for reference in Dockerfile instruction from that point onwards.
The `USER` instruction on line 4 evaluates to `what_user`, since at that point the `username` argument has a value of `what_user` which was passed on the command line. Prior to its definition by an `ARG` instruction, any use of a variable results in an empty string.

An `ARG` variable declared within a build stage is automatically inherited by other stages based on that stage. Unrelated build stages do not have access to the variable. To use an argument in multiple distinct stages, each stage must include the `ARG` instruction, or they must both be based on a shared base stage in the same Dockerfile where the variable is declared.

***Using ARG variables***

You can use an `ARG` or an `ENV` instruction to specify variables that are available to the `RUN` instruction. *Environment variables defined using the `ENV` instruction always override an `ARG` instruction of the same name.* Consider this Dockerfile with an `ENV` and `ARG` instruction.

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
ENV CONT_IMG_VER=v1.0.0
RUN echo $CONT_IMG_VER
```

Then, assume this image is built with this command:

```
docker build --build-arg CONT_IMG_VER=v2.0.1 .
```

In this case, the `RUN` instruction uses `v1.0.0` instead of the `ARG` setting passed by the `user:v2.0.1` This behavior is similar to a shell script where a locally scoped variable overrides the variables passed as arguments or inherited from environment, from its point of definition.

Using the example above but a different `ENV` specification you can create more useful interactions between `ARG` and `ENV` instructions:

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
ENV CONT_IMG_VER=${CONT_IMG_VER:-v1.0.0}
RUN echo $CONT_IMG_VER
```

*Unlike an `ARG` instruction, ENV values are always persisted in the built image.* Consider a `docker build` without the `--build-arg` flag:

```
docker build .
```

Using this Dockerfile example, `CONT_IMG_VER` is still persisted in the image but its value would be `v1.0.0` as it is the default set in line 3 by the `ENV` instruction.

The variable expansion technique in this example allows you to pass arguments from the command line and persist them in the final image by leveraging the `ENV` instruction. Variable expansion is only supported for a limited set of Dockerfile instructions.

***Predefined ARGs***

Docker has a set of predefined `ARG` variables that you can use without a corresponding `ARG` instruction in the Dockerfile.

* `HTTP_PROXY`/`http_proxy`
* `HTTPS_PROXY`/`https_proxy`
* `FTP_PROXY`/`ftp_proxy`
* `NO_PROXY`/`no_proxy`
* `ALL_PROXY`/`all_proxy`

To use these, pass them on the command line using the `--build-arg` flag, for example:

```
docker build --build-arg HTTPS_PROXY=https://my-proxy.example.com .
```

*By default, these pre-defined variables are excluded from the output of docker history.* Excluding them reduces the risk of accidentally leaking sensitive authentication information in an `HTTP_PROXY` variable.

For example, consider building the following Dockerfile using `--build-arg HTTP_PROXY=http://user:pass@proxy.lon.example.com`

```dockerfile
FROM ubuntu
RUN echo "Hello World"
```

In this case, the value of the `HTTP_PROXY` variable is not available in the docker history and is not cached. If you were to change location, and your proxy server changed to `http://user:pass@proxy.sfo.example.com`, a subsequent build does not result in a cache miss.

If you need to override this behaviour then you may do so by adding an `ARG` statement in the Dockerfile as follows:

```dockerfile
FROM ubuntu
ARG HTTP_PROXY
RUN echo "Hello World"
```

When building this Dockerfile, the `HTTP_PROXY` is preserved in the docker history, and changing its value invalidates the build cache.

***Automatic platform ARGs in the global scope***

This feature is only available when using the BuildKit backend.

BuildKit supports a predefined set of `ARG` variables with information on the platform of the node performing the build (*build platform*) and on the platform of the resulting image (*target platform*). The *target platform* can be specified with the `--platform` flag on `docker build`.

The following ARG variables are set automatically:

* **`TARGETPLATFORM`** - platform of the build result. Eg `linux/amd64`, `linux/arm/v7`, `windows/amd64`.
* **`TARGETOS`** - OS component of `TARGETPLATFORM`
* **`TARGETARCH`** - architecture component of `TARGETPLATFORM`
* **`TARGETVARIANT`** - variant component of `TARGETPLATFORM`
* **`BUILDPLATFORM`** - platform of the node performing the build.
* **`BUILDOS`** - OS component of `BUILDPLATFORM`
* **`BUILDARCH`** - architecture component of `BUILDPLATFORM`
* **`BUILDVARIANT`** - variant component of `BUILDPLATFORM`

These arguments are defined in the global scope so are not automatically available inside build stages or for your `RUN` commands. To expose one of these arguments inside the build stage redefine it without value.

For example:

```dockerfile
FROM alpine
ARG TARGETPLATFORM
RUN echo "I'm building for $TARGETPLATFORM"
```

***BuildKit built-in build args***

| Arg                            | Type   | Description                                                                                                                            |
|--------------------------------|--------|----------------------------------------------------------------------------------------------------------------------------------------|
| BUILDKIT_CACHE_MOUNT_NS        | String | Set optional cache ID namespace.                                                                                                       |
| BUILDKIT_CONTEXT_KEEP_GIT_DIR  | Bool   | Trigger Git context to keep the `.git` directory.                                                                                      |
| BUILDKIT_HISTORY_PROVENANCE_V1 | Bool   | Enable SLSA Provenance v1 for build history record.                                                                                    |
| BUILDKIT_INLINE_CACHE2         | Bool   | Inline cache metadata to image config or not.                                                                                          |
| BUILDKIT_MULTI_PLATFORM        | Bool   | Opt into deterministic output regardless of multi-platform output or not.                                                              |
| BUILDKIT_SANDBOX_HOSTNAME      | String | Set the hostname (default `buildkitsandbox`)                                                                                           |
| BUILDKIT_SYNTAX                | String | Set frontend image                                                                                                                     |
| SOURCE_DATE_EPOCH              | Int    | Set the Unix timestamp for created image and layers. More info from reproducible builds. Supported since Dockerfile 1.5, BuildKit 0.11 |

**Example: keep `.git` dir**
When using a Git context, `.git` dir is not kept on checkouts. It can be useful to keep it around if you want to retrieve git information during your build:

```dockerfile
# syntax=docker/dockerfile:1
FROM alpine
WORKDIR /src
RUN --mount=target=. \
  make REVISION=$(git rev-parse HEAD) build
```

```
docker build --build-arg BUILDKIT_CONTEXT_KEEP_GIT_DIR=1 https://github.com/user/repo.git#main
```

***Impact on build caching***

`ARG` variables are not persisted into the built image as `ENV` variables are. However, `ARG` variables do impact the build cache in similar ways. If a Dockerfile defines an `ARG` variable whose value is different from a previous build, then a "cache miss" occurs upon its first usage, not its definition. In particular, all `RUN` instructions following an `ARG` instruction use the `ARG` variable implicitly (as an *environment variable*), thus can cause a cache miss. All predefined `ARG` variables are exempt from caching unless there is a matching `ARG` statement in the Dockerfile.

For example, consider these two Dockerfile:

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
RUN echo $CONT_IMG_VER
```

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
RUN echo hello
```

If you specify `--build-arg CONT_IMG_VER=<value>` on the command line, in both cases, the specification on line 2 doesn't cause a cache miss; line 3 does cause a cache miss. `ARG CONT_IMG_VER` causes the `RUN` line to be identified as the same as running `CONT_IMG_VER=<value> echo hello`, so if the `<value>` changes, you get a cache miss.

Consider another example under the same command line:

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
ENV CONT_IMG_VER=$CONT_IMG_VER
RUN echo $CONT_IMG_VER
```

In this example, the cache miss occurs on line 3. The miss happens because the variable's value in the `ENV` references the `ARG` variable and that variable is changed through the command line. In this example, the `ENV` command causes the image to include the value.

If an `ENV` instruction overrides an `ARG` instruction of the same name, like this Dockerfile:

```dockerfile
FROM ubuntu
ARG CONT_IMG_VER
ENV CONT_IMG_VER=hello
RUN echo $CONT_IMG_VER
```

Line 3 doesn't cause a cache miss because the value of `CONT_IMG_VER` is a constant (`hello`). As a result, the environment variables and values used on the RUN (line 4) doesn't change between builds.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#arg)

**Examples**

* Simple argument use

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/arg-simple/Dockerfile)

```dockerfile
FROM alpine
ARG NICKNAME
RUN echo "Hello, $NICKNAME!"
WORKDIR /home/${NICKNAME}

```

```console
$ docker build -t arg-simple --build-arg NICKNAME=katheroine .
[+] Building 2.8s (7/7) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 118B                                                                                                                                                                                                                                         0.0s
 => [internal] load metadata for docker.io/library/alpine:latest                                                                                                                                                                                                             1.7s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/3] FROM docker.io/library/alpine:latest@sha256:4bcff63911fcb4448bd4fdacec207030997caf25e9bea4045fa6c8c44de311d1                                                                                                                                                0.0s
 => [2/3] RUN echo "Hello, katheroine!"                                                                                                                                                                                                                                      0.6s
 => [3/3] WORKDIR /home/katheroine                                                                                                                                                                                                                                           0.1s
 => exporting to image                                                                                                                                                                                                                                                       0.2s
 => => exporting layers                                                                                                                                                                                                                                                      0.1s
 => => writing image sha256:e91483afc724d058961cfa8150a5bef2b18e75964bc6a302b24ea3ea67fb9df3                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/arg-simple
```

```console
$ docker images
REPOSITORY   TAG       IMAGE ID       CREATED          SIZE
arg-simple   latest    e91483afc724   33 seconds ago   8.31MB
```

```console
$ docker run -it --name arg-simple-argument arg-simple
/home/katheroine #
```

## [`ENV`](https://docs.docker.com/reference/dockerfile/#env)

The `ENV` instruction sets the *environment variable* `<key>` to the value `<value>`.

```dockerfile
ENV <key>=<value> [<key>=<value>...]
```

This value will be in the environment for all subsequent instructions in the build stage and can be replaced inline in many as well. The value will be interpreted for other environment variables, so quote characters will be removed if they are not escaped. Like command line parsing, quotes and backslashes can be used to include spaces within values.

Example:

```docker
ENV MY_NAME="John Doe"
ENV MY_DOG=Rex\ The\ Dog
ENV MY_CAT=fluffy
```

The `ENV` instruction allows for multiple `<key>=<value> ...` variables to be set at one time, and the example below will yield the same net results in the final image:

```dockerfile
ENV MY_NAME="John Doe" MY_DOG=Rex\ The\ Dog \
    MY_CAT=fluffy
```

The environment variables set using `ENV` will persist when a container is run from the resulting image. You can view the values using `docker inspect`, and change them using `docker run --env <key>=<value>`.

A stage inherits any environment variables that were set using `ENV` by its parent stage or any ancestor. Refer to the multi-stage builds section in the manual for more information.

Environment variable persistence can cause unexpected side effects. For example, setting `ENV DEBIAN_FRONTEND=noninteractive` changes the behavior of `apt-get`, and may confuse users of your image.

If an environment variable is only needed during build, and not in the final image, consider setting a value for a single command instead:

```dockerfile
RUN DEBIAN_FRONTEND=noninteractive apt-get update && apt-get install -y ...
```

Or using `ARG`, which is not persisted in the final image:

```dockerfile
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y ...
```

***Alternative syntax***

The `ENV` instruction also allows an alternative syntax `ENV <key> <value>`, omitting the `=`. For example:

```dockerfile
ENV MY_VAR my-value
```

This syntax does not allow for multiple environment-variables to be set in a single `ENV` instruction, and can be confusing. For example, the following sets a single environment variable (`ONE`) with value `"TWO= THREE=world"`:

```dockerfile
ENV ONE TWO= THREE=world
```

The alternative syntax is supported for backward compatibility, but discouraged for the reasons outlined above, and may be removed in a future release.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#env)

**Examples**

* Simple environment variable set

```console
$ docker images
REPOSITORY   TAG       IMAGE ID   CREATED   SIZE
```

[*Dockerfile*](../instructions.examples/env-simple/Dockerfile)

```dockerfile
FROM ubuntu
ENV MY_ENV="Hi, there!"
RUN echo ${MY_ENV}
CMD echo ${MY_ENV}

```

```console
$ docker build -t env-simple .
[+] Building 6.3s (7/7) FINISHED                                                                                                                                                                                                                                   docker:default
 => [internal] load build definition from Dockerfile                                                                                                                                                                                                                         0.0s
 => => transferring dockerfile: 111B                                                                                                                                                                                                                                         0.0s
 => [internal] load metadata for docker.io/library/ubuntu:latest                                                                                                                                                                                                             5.0s
 => [auth] library/ubuntu:pull token for registry-1.docker.io                                                                                                                                                                                                                0.0s
 => [internal] load .dockerignore                                                                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                                                              0.0s
 => CACHED [1/2] FROM docker.io/library/ubuntu:latest@sha256:9cbed754112939e914291337b5e554b07ad7c392491dba6daf25eef1332a22e8                                                                                                                                                0.0s
 => [2/2] RUN echo Hi, there!                                                                                                                                                                                                                                                0.9s
 => exporting to image                                                                                                                                                                                                                                                       0.1s
 => => exporting layers                                                                                                                                                                                                                                                      0.0s
 => => writing image sha256:bdff3f30aac8d39e668e0dedfd22af318f1e9926101752ea81e2cf043baa336d                                                                                                                                                                                 0.0s
 => => naming to docker.io/library/env-simple                                                                                                                                                                                                                                0.0s

 1 warning found (use docker --debug to expand):
 - JSONArgsRecommended: JSON arguments recommended for CMD to prevent unintended behavior related to OS signals (line 4)
```

```console
$ docker images
REPOSITORY   TAG       IMAGE ID       CREATED              SIZE
env-simple   latest    bdff3f30aac8   About a minute ago   78.1MB
```

```console
$ docker run -it --name env-simple-ev env-simple
Hi, there!
```

## [`CMD`](https://docs.docker.com/reference/dockerfile/#cmd)

The `CMD` instruction sets the command to be executed when running a container from an image.

You can specify CMD instructions using shell or exec forms:

* **Exec form**

```dockerfile
CMD ["executable","param1","param2"]
```

* **Fxec form, as default parameters to `ENTRYPOINT`**

```dockerfile
CMD ["param1","param2"]
```

* **Shell form**

```dockerfile
CMD command param1 param2
```

*There can only be one `CMD` instruction in a Dockerfile.* If you list more than one `CMD`, only the last one takes effect.

The purpose of a `CMD` is to provide defaults for an executing container. These defaults can include an executable, or they can omit the executable, in which case you must specify an `ENTRYPOINT` instruction as well.

If you would like your container to run the same executable every time, then you should consider using `ENTRYPOINT` in combination with `CMD`. If the user specifies arguments to `docker run` then they will override the default specified in `CMD`, but still use the default `ENTRYPOINT`.

If `CMD` is used to provide default arguments for the `ENTRYPOINT` instruction, both the `CMD` and `ENTRYPOINT` instructions should be specified in the exec form.

Don't confuse `RUN` with `CMD`. `RUN` actually runs a command and commits the result; `CMD` doesn't execute anything at build time, but specifies the intended command for the image.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#cmd)
