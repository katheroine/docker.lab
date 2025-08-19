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
