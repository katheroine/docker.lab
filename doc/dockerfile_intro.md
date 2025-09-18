# Introduction to the Dockerfile

Docker builds images by reading the instructions from a Dockerfile. A [**Dockerfile**](https://docs.docker.com/reference/dockerfile/) is a text file containing instructions for building your source code.

Dockerfiles are crucial inputs for image builds and can facilitate automated, multi-layer image builds based on your unique configurations. Dockerfiles can start simple and grow with your needs to support more complex scenarios.

**Filename**

The default filename to use for a Dockerfile is `Dockerfile`, without a file extension. Using the default name allows you to run the `docker build` command without having to specify additional command flags.

Some projects may need distinct Dockerfiles for specific purposes. A common convention is to name these `<something>.Dockerfile`. You can specify the Dockerfile filename using the [`--file`](https://docs.docker.com/reference/cli/docker/buildx/build/#file) flag for the `docker build` command.


***Docker images***

Docker images consist of layers. Each layer is the result of a build instruction in the Dockerfile. Layers are stacked sequentially, and each one is a delta representing the changes applied to the previous layer.

**Most common Dockerfile instructions**

| Instruction	                                                                 | Description
|--------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [`FROM <image>`](https://docs.docker.com/reference/dockerfile/#from)           | Defines a base for your image.                                                                                                                                                                           |
| [`RUN <command>`](https://docs.docker.com/reference/dockerfile/#run)           | Executes any commands in a new layer on top of the current image and commits the result. RUN also has a shell form for running commands.                                                                 |
| [`WORKDIR <directory>`](https://docs.docker.com/reference/dockerfile/#workdir) | Sets the working directory for any `RUN`, `CMD`, `ENTRYPOINT`, `COPY`, and ADD instructions that follow it in the Dockerfile.                                                                            |
| [`COPY <src> <dest>`](https://docs.docker.com/reference/dockerfile/#copy)      | Copies new files or directories from <src> and adds them to the filesystem of the container at the path `<dest>`.                                                                                        |
| [`CMD <command> `](https://docs.docker.com/reference/dockerfile/#cmd)          | Lets you define the default program that is run once you start the container based on this image. Each Dockerfile only has one `CMD`, and only the last `CMD` instance is respected when multiple exist. |

-- [Docker Documentation](https://docs.docker.com/build/concepts/dockerfile)

**Example**

[*Dockerfile*](../examples/simple-hello-world/Dockerfile)

```dockerfile
# Use an official Ubuntu base image
FROM ubuntu:latest

# Set the command to run when the container starts
# This command will print the desired message to standard output
CMD ["echo", "Hello, World! This is my_container running."]
```

*Building image*

This command should be run from the inside of the same directory the Dockerfile is placed.
* `-t` option creates a name (and optionally a tag - not used in this example) for the image
* `simple-hello-world` is the name of the image
* `.` means that the Dockerfile should be found in the current working directory

```console
$ docker build -t simple-hello-world .
```

```console
$ docker image ls
REPOSITORY                 TAG       IMAGE ID       CREATED        SIZE
simple-hello-world         latest    97779def6838   5 weeks ago    78.1MB
```

*Running (creating & starting) the container*

```console
$ docker run --name ranek_obwarzanek simple-hello-world:latest
Hello, World! This is my_container running.
```

```console
$ docker ps -a
CONTAINER ID   IMAGE                       COMMAND                  CREATED         STATUS                     PORTS     NAMES
4c96e7369d16   simple-hello-world:latest   "echo 'Hello, World!…"   2 minutes ago   Exited (0) 6 seconds ago             ranek_obwarzanek
```
