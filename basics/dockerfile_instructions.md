# Dockerfile instructions

1. [`FROM`](#from)
2. [`RUN`](#run)
3. [`ADD`](#add)

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

The `FROM` instruction initializes a new build stage and sets the base image for subsequent instructions. As such, a valid Dockerfile must start with a `FROM` instruction. The image can be any valid image.

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

* **Shell form**

```dockerfile
RUN [OPTIONS] <command> ...
```

* **Exec form**

```dockerfile
RUN [OPTIONS] [ "<command>", ... ]
```

The `RUN` instruction will execute any commands *to create a new layer on top of the current image*. The added layer is used in the next step in the Dockerfile.

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

* **Shell form**

```dockerfile
ADD [OPTIONS] <src> ... <dest>
```

* **Exec form**

```dockerfile
ADD [OPTIONS] ["<src>", ... "<dest>"]
```

The `ADD` instruction copies new files or directories from `<src>` and adds them to the filesystem of the image at the path `<dest>`. Files and directories can be copied from the build context, a remote URL, or a Git repository.

The `ADD` and `COPY` instructions are functionally similar, but serve slightly different purposes. Learn more about the differences between `ADD` and `COPY`.

**Options**

| Option                                                                             | Description                                                         |
|------------------------------------------------------------------------------------|---------------------------------------------------------------------|
| [--keep-git-dir](https://docs.docker.com/reference/dockerfile/#add---keep-git-dir) | lets you preserve the `.git` directory                              |
| [--checksum](https://docs.docker.com/reference/dockerfile/#add---checksum)         | lets you verify the checksum of a remote resource                   |
| [--chown](https://docs.docker.com/reference/dockerfile/#add---chown---chmod)       | lets you define the permission bits using build arguments           |
| [--chmod](https://docs.docker.com/reference/dockerfile/#add---chown---chmod)       | lets you define the permission bits using build arguments           |
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
