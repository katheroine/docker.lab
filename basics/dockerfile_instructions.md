# Dockerfile instructions

1. [`FROM`](#from)

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
