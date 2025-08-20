# CLI

## What is Docker CLI?

**Docker CLI** tool is *a command line application used to interact with the `dockerd` daemon*. The `dockerd` daemon is the process that manages containers and handles all the commands sent from the CLI by exposing an API endpoint. So both dockerd and Docker CLI pieces are needed for docker to work.

![Docker Architecture](https://cdn.prod.website-files.com/681e366f54a6e3ce87159ca4/687d7a52cccb7374efbbf8ca_image2-49.png)

-- [Sysdig Page](https://www.sysdig.com/learn-cloud-native/what-is-docker-cli)

Depending on your Docker system configuration, you may be required to preface each `docker` command with `sudo`. To avoid having to use `sudo` with the `docker` command, your system administrator can create a Unix group called `docker` and add users to it.

-- [Docker Documentation](https://docs.docker.com/reference/cli/docker)

## Most important [Docker CLI commands](https://docs.docker.com/reference/cli/docker)

### [Displaying all Docker CLI high-level commands](https://docs.docker.com/reference/cli/docker)

```bash
docker
```

```
Usage:  docker [OPTIONS] COMMAND

A self-sufficient runtime for containers

Common Commands:
  run         Create and run a new container from an image
  exec        Execute a command in a running container
  ps          List containers
  build       Build an image from a Dockerfile
  bake        Build from a file
  pull        Download an image from a registry
  push        Upload an image to a registry
  images      List images
  login       Authenticate to a registry
  logout      Log out from a registry
  search      Search Docker Hub for images
  version     Show the Docker version information
  info        Display system-wide information

Management Commands:
  builder     Manage builds
  buildx*     Docker Buildx
  checkpoint  Manage checkpoints
  compose*    Docker Compose
  container   Manage containers
  context     Manage contexts
  image       Manage images
  manifest    Manage Docker image manifests and manifest lists
  network     Manage networks
  plugin      Manage plugins
  system      Manage Docker
  trust       Manage trust on Docker images
  volume      Manage volumes

Swarm Commands:
  config      Manage Swarm configs
  node        Manage Swarm nodes
  secret      Manage Swarm secrets
  service     Manage Swarm services
  stack       Manage Swarm stacks
  swarm       Manage Swarm

Commands:
  attach      Attach local standard input, output, and error streams to a running container
  commit      Create a new image from a container's changes
  cp          Copy files/folders between a container and the local filesystem
  create      Create a new container
  diff        Inspect changes to files or directories on a container's filesystem
  events      Get real time events from the server
  export      Export a container's filesystem as a tar archive
  history     Show the history of an image
  import      Import the contents from a tarball to create a filesystem image
  inspect     Return low-level information on Docker objects
  kill        Kill one or more running containers
  load        Load an image from a tar archive or STDIN
  logs        Fetch the logs of a container
  pause       Pause all processes within one or more containers
  port        List port mappings or a specific mapping for the container
  rename      Rename a container
  restart     Restart one or more containers
  rm          Remove one or more containers
  rmi         Remove one or more images
  save        Save one or more images to a tar archive (streamed to STDOUT by default)
  start       Start one or more stopped containers
  stats       Display a live stream of container(s) resource usage statistics
  stop        Stop one or more running containers
  tag         Create a tag TARGET_IMAGE that refers to SOURCE_IMAGE
  top         Display the running processes of a container
  unpause     Unpause all processes within one or more containers
  update      Update configuration of one or more containers
  wait        Block until one or more containers stop, then print their exit codes

Global Options:
      --config string      Location of client config files (default "/home/katheroine/.docker")
  -c, --context string     Name of the context to use to connect to the daemon (overrides DOCKER_HOST env var and default context set with "docker context use")
  -D, --debug              Enable debug mode
  -H, --host list          Daemon socket to connect to
  -l, --log-level string   Set the logging level ("debug", "info", "warn", "error", "fatal") (default "info")
      --tls                Use TLS; implied by --tlsverify
      --tlscacert string   Trust certs signed only by this CA (default "/home/katheroine/.docker/ca.pem")
      --tlscert string     Path to TLS certificate file (default "/home/katheroine/.docker/cert.pem")
      --tlskey string      Path to TLS key file (default "/home/katheroine/.docker/key.pem")
      --tlsverify          Use TLS and verify the remote
  -v, --version            Print version information and quit

Run 'docker COMMAND --help' for more information on a command.

For more help on how to use Docker, head to https://docs.docker.com/go/guides/
```

### [Managing images](https://docs.docker.com/reference/cli/docker/image)

#### [Displaying all commands managing images](https://docs.docker.com/reference/cli/docker/image)

```
docker image
```

```
Usage:  docker image COMMAND

Manage images

Commands:
  build       Build an image from a Dockerfile
  history     Show the history of an image
  import      Import the contents from a tarball to create a filesystem image
  inspect     Display detailed information on one or more images
  load        Load an image from a tar archive or STDIN
  ls          List images
  prune       Remove unused images
  pull        Download an image from a registry
  push        Upload an image to a registry
  rm          Remove one or more images
  save        Save one or more images to a tar archive (streamed to STDOUT by default)
  tag         Create a tag TARGET_IMAGE that refers to SOURCE_IMAGE

Run 'docker image COMMAND --help' for more information on a command.

```

#### [Displaying images](https://docs.docker.com/reference/cli/docker/image/ls)

```
docker image ls [OPTIONS] [REPOSITORY[:TAG]]
```

**Aliases**

```
docker image list
```

```
docker images
```

**Options**

```
  -a, --all             Show all images (default hides intermediate images)
      --digests         Show digests
  -f, --filter filter   Filter output based on conditions provided
      --format string   Format output using a custom template:
                        'table':            Print output in table format with column headers (default)
                        'table TEMPLATE':   Print output in table format using the given Go template
                        'json':             Print in JSON format
                        'TEMPLATE':         Print output using the given Go template.
                        Refer to https://docs.docker.com/go/formatting/ for more information about formatting output with templates
      --no-trunc        Don't truncate output
  -q, --quiet           Only show image IDs
      --tree            List multi-platform images as a tree (EXPERIMENTAL)
```

*Filtering results*

You can use the `--filter` flag to scope your commands. When filtering, the commands only include entries that match the pattern you specify.

The `--filter` flag expects a `key`-`value` pair separated by an operator.

```
docker COMMAND --filter "KEY=VALUE"
```

The key represents the field that you want to filter on. The value is the pattern that the specified field must match. The operator can be either equals (`=`) or not equals (`!=`).

For example, the command docker images --filter reference=alpine filters the output of the docker images command to only print alpine images.

-- [Docker Documentation](https://docs.docker.com/engine/cli/filter)

**Examples**

```
docker image ls
```

```
REPOSITORY                 TAG       IMAGE ID       CREATED        SIZE
docker/welcome-to-docker   latest    6caf772f5178   3 weeks ago    14.1MB
ubuntu                     latest    65ae7a6f3544   5 weeks ago    78.1MB
hello-world                latest    74cc54e27dc4   6 months ago   10.1kB
```

```
docker images ubuntu
```

```
REPOSITORY   TAG       IMAGE ID       CREATED       SIZE
ubuntu       latest    65ae7a6f3544   5 weeks ago   78.1MB
```

```
docker image ls -f "reference=ubuntu"
```

```
REPOSITORY   TAG       IMAGE ID       CREATED       SIZE
ubuntu       latest    65ae7a6f3544   5 weeks ago   78.1MB
```

#### [Displayed information about an image](https://docs.docker.com/reference/cli/docker/inspect/)

```
docker image inspect [OPTIONS] IMAGE [IMAGE...]
```

Display detailed information on one or more images.

**Options**

```
  -f, --format string     Format output using a custom template:
                          'json':             Print in JSON format
                          'TEMPLATE':         Print output using the given Go template.
                          Refer to https://docs.docker.com/go/formatting/ for more information about formatting output with templates
      --platform string   Inspect a specific platform of the multi-platform image.
                          If the image or the server is not multi-platform capable, the command will error out if the platform does not match.
                          'os[/arch[/variant]]': Explicit platform (eg. linux/amd64)
```

#### [Showing history of an image](https://docs.docker.com/reference/cli/docker/image/history)

```
docker image history [OPTIONS] IMAGE
```

**Aliases**

```
docker history
```

**Options**

```
      --format string     Format output using a custom template:
                          'table':            Print output in table format with column headers (default)
                          'table TEMPLATE':   Print output in table format using the given Go template
                          'json':             Print in JSON format
                          'TEMPLATE':         Print output using the given Go template.
                          Refer to https://docs.docker.com/go/formatting/ for more information about formatting output with templates
  -H, --human             Print sizes and dates in human readable format (default true)
      --no-trunc          Don't truncate output
      --platform string   Show history for the given platform. Formatted as "os[/arch[/variant]]" (e.g., "linux/amd64")
  -q, --quiet             Only show image IDs
```

**Examples**

```
docker image inspect ubuntu
```

```
[
    {
        "Id": "sha256:0abb83f46a8285cb2277da6254f1c1c41705598a3a9946cbe7101036392f45e2",
        "RepoTags": [
            "ubuntu:latest"
        ],
        "RepoDigests": [],
        "Parent": "",
        "Comment": "Imported from -",
        "Created": "2025-08-19T18:51:34.180556348Z",
        "DockerVersion": "28.1.1",
        "Author": "",
        "Config": {
            "Hostname": "",
            "Domainname": "",
            "User": "",
            "AttachStdin": false,
            "AttachStdout": false,
            "AttachStderr": false,
            "Tty": false,
            "OpenStdin": false,
            "StdinOnce": false,
            "Env": null,
            "Cmd": null,
            "Image": "",
            "Volumes": null,
            "WorkingDir": "",
            "Entrypoint": null,
            "OnBuild": null,
            "Labels": null
        },
        "Architecture": "amd64",
        "Os": "linux",
        "Size": 80637789,
        "GraphDriver": {
            "Data": {
                "MergedDir": "/var/lib/docker/overlay2/ed86862a6c14b13d500c066bf9bb95a10199c610de52f0fe57a33c6232391fe8/merged",
                "UpperDir": "/var/lib/docker/overlay2/ed86862a6c14b13d500c066bf9bb95a10199c610de52f0fe57a33c6232391fe8/diff",
                "WorkDir": "/var/lib/docker/overlay2/ed86862a6c14b13d500c066bf9bb95a10199c610de52f0fe57a33c6232391fe8/work"
            },
            "Name": "overlay2"
        },
        "RootFS": {
            "Type": "layers",
            "Layers": [
                "sha256:ccd12804a82bf2a9ea0abab4de9f59ab01e439aa5a8a77df5ff4db400ab8767c"
            ]
        },
        "Metadata": {
            "LastTagTime": "2025-08-19T20:51:34.186215651+02:00"
        }
    }
]
```

**Examples**

```
docker image history ubuntu
```

```
IMAGE          CREATED       CREATED BY                                      SIZE      COMMENT
65ae7a6f3544   5 weeks ago   /bin/sh -c #(nop)  CMD ["/bin/bash"]            0B
<missing>      5 weeks ago   /bin/sh -c #(nop) ADD file:b4619a63cd7829e13…   78.1MB
<missing>      5 weeks ago   /bin/sh -c #(nop)  LABEL org.opencontainers.…   0B
<missing>      5 weeks ago   /bin/sh -c #(nop)  LABEL org.opencontainers.…   0B
<missing>      5 weeks ago   /bin/sh -c #(nop)  ARG LAUNCHPAD_BUILD_ARCH     0B
<missing>      5 weeks ago   /bin/sh -c #(nop)  ARG RELEASE                  0B
```

#### [Loading image](https://docs.docker.com/reference/cli/docker/image/load)

```
docker image load [OPTIONS]
```

Loads an image from a tar archive or STDIN.

**Aliases**

```
docker load
```

**Options**

```
  -i, --input string      Read from tar archive file, instead of STDIN
      --platform string   Load only the given platform variant. Formatted as "os[/arch[/variant]]" (e.g., "linux/amd64")
  -q, --quiet             Suppress the load output
```

**Examples**

```
docker image load < ubuntu_latest.tar.gz
```

```
107cbdaeec04: Loading layer [==================================================>]  80.63MB/80.63MB
Loaded image: ubuntu:latest
```

```
docker load --input ubuntu_latest.tar.gz
```

```
107cbdaeec04: Loading layer [==================================================>]  80.63MB/80.63MB
Loaded image: ubuntu:latest
```

#### [Importing image](https://docs.docker.com/reference/cli/docker/image/import)

```
docker image import [OPTIONS] file|URL|- [REPOSITORY[:TAG]]
```

Import the contents from a tarball to create a filesystem image.

**Aliases**

```
docker import
```

**Options**

```
  -c, --change list       Apply Dockerfile instruction to the created image
  -m, --message string    Set commit message for imported image
      --platform string   Set platform if server is multi-platform capable
```

*Import with new configurations*

The `--change` option applies Dockerfile instructions to the image that is created. Not all Dockerfile instructions are supported; the list of instructions is limited to metadata (configuration) changes. The following Dockerfile instructions are supported:

* CMD
* ENTRYPOINT
* ENV
* EXPOSE
* HEALTHCHECK
* LABEL
* ONBUILD
* STOPSIGNAL
* USER
* VOLUME
* WORKDIR

**Examples**

* Import from a local file

```
cat ubuntu_latest.tar.gz | docker import - ubuntu:latest
```

* Import to docker from a local archive

```
docker import ubuntu_latest.tar.gz ubuntu:latest
```

* Import from a remote location

```
docker import http://localhost/docker-images/ubuntu_latest.tar.gz
```

#### [Saving image](https://docs.docker.com/reference/cli/docker/image/save)

```
docker image save [OPTIONS] IMAGE [IMAGE...]
```

Save one or more images to a tar archive (streamed to STDOUT by default).

**Aliases**

```
docker save
```

**Options**

```
  -o, --output string     Write to a file, instead of STDOUT
      --platform string   Save only the given platform variant. Formatted as "os[/arch[/variant]]" (e.g., "linux/amd64")
```

**Examples**

```
docker image save ubuntu > ubuntu_latest.tar
```

```
docker image save ubuntu -o ubuntu_latest.tar
```

```
docker image save -o ubuntu_latest.tar ubuntu
```

```
docker image save -o ubuntu_latest.tar ubuntu:latest
```

```
docker image save ubuntu:latest | gzip > ubuntu_latest.tar.gz
```

#### [Removing image](https://docs.docker.com/reference/cli/docker/image/rm)

```
docker image rm [OPTIONS] IMAGE [IMAGE...]
```

**Aliases**

```
docker image remove
```

```
docker rmi
```

**Options**

```
  -f, --force      Force removal of the image
      --no-prune   Do not delete untagged parents
```

**Examples**

```
docker image rm ubuntu
```

```
Untagged: ubuntu:latest
Deleted: sha256:0abb83f46a8285cb2277da6254f1c1c41705598a3a9946cbe7101036392f45e2
Deleted: sha256:ccd12804a82bf2a9ea0abab4de9f59ab01e439aa5a8a77df5ff4db400ab8767c
```

Each SHA256 is an image identifier and each one points out a single removed image. An Docker image can have many layers, each one is seen here as a separate SHA256 ID.

```
docker image rm 6caf772f5178
```

```
Untagged: docker/welcome-to-docker:latest
Untagged: docker/welcome-to-docker@sha256:c4d56c24da4f009ecf8352146b43497fe78953edb4c679b841732beb97e588b0
Deleted: sha256:6caf772f5178c851c3af9138578d587cad36361bdb27d235f5b55d35691c2777
Deleted: sha256:79e17aa8398c62ae2cf5e5cc2d8053285652f1d3bd09a1bf19307cb1f31a8423
Deleted: sha256:9b1b8eed3aa5a8d416502018803e4362ff022d230fc8afc666fc9e24b11091cc
Deleted: sha256:15b574c25135fc2ec07564fb4437901f5ddd0e01e01ef77d385770b6a999d50f
Deleted: sha256:a539ae0abb1b415900b41d2f1b7693fd51c64dcf272ef9c7c66e740a122c0d78
Deleted: sha256:2e459a00e6d75d1c6451b14da34e9b1c406cfc31c4783fe6ecd2b69e583862bd
Deleted: sha256:3a911394a947eb016bdf0c134c3b05a89ea09b997d3601bd2678dc969e873b1a
Deleted: sha256:e6bbf0b400bf1cd15029c06a499f4d8d0512b864f4ecc8d73d4510d06b66ad5a
Deleted: sha256:418dccb7d85a63a6aa574439840f7a6fa6fd2321b3e2394568a317735e867d35
```

When there are some containers on the host created from the image, this image cannot be simply deleted. In such case, the option `-f` is needed to be used.

```
docker image rm 74cc54e27dc4
```

```
Error response from daemon: conflict: unable to delete 74cc54e27dc4 (must be forced) - image is being used by stopped container 10fead0074fa
```

```
docker image rm -f 74cc54e27dc4
```

```
Untagged: hello-world:latest
Untagged: hello-world@sha256:ec153840d1e635ac434fab5e377081f17e0e15afab27beb3f726c3265039cfff
Deleted: sha256:74cc54e27dc41bb10dc4b2226072d469509f2f22f1a3ce74f4a59661a1d44602
```

#### [Removing unused images](https://docs.docker.com/reference/cli/docker/image/prune)

```
https://docs.docker.com/reference/cli/docker/image/prune
```

**Options**

```
  -a, --all             Remove all unused images, not just dangling ones
      --filter filter   Provide filter values (e.g. "until=<timestamp>")
  -f, --force           Do not prompt for confirmation
```

**Examples**

```
docker image prune
```

```
WARNING! This will remove all dangling images.
Are you sure you want to continue? [y/N] y
Total reclaimed space: 0B
```
