# Docker

## What is Docker

[**Docker**](https://en.wikipedia.org/wiki/Docker_(software)) is a set of [platform as a service (PaaS)](https://en.wikipedia.org/wiki/Platform_as_a_service) products that use **OS-level virtualization** to *deliver software in packages called containers*. The service has both free and premium tiers.

*The software that hosts the containers* is called **Docker Engine**. It was first released in 2013 and is developed by Docker, Inc.

Docker is a tool that is used to automate the deployment of applications in lightweight containers so that applications can work efficiently in different environments in isolation.

-- [Wikipedia](https://en.wikipedia.org/wiki/Docker_(software))

[**Docker**](https://docs.docker.com/get-started/docker-overview) is an open platform for developing, shipping, and running applications. Docker enables you to separate your applications from your infrastructure so you can deliver software quickly. With Docker, you can manage your infrastructure in the same ways you manage your applications. By taking advantage of Docker's methodologies for shipping, testing, and deploying code, you can significantly reduce the delay between writing code and running it in production.

-- [Docker Documentation](https://docs.docker.com/get-started/docker-overview)

**Containers** are isolated from one another and bundle their own software, libraries and configuration files; they can communicate with each other through well-defined channels. Because *all of the containers share the services of a single operating system kernel*, they use fewer resources than virtual machines.

-- [Wikipedia](https://en.wikipedia.org/wiki/Docker_(software)#Background)

## The Docker platform

Docker provides the ability to package and run an application in *a loosely isolated environment* called a *container*. The isolation and security lets you *run many containers simultaneously* on a given host. Containers are lightweight and contain everything needed to run the application, so you don't need to rely on what's installed on the host. You can share containers while you work, and be sure that everyone you share with gets the same container that works in the same way.

Docker provides tooling and a platform to manage the lifecycle of your containers:

* Develop your application and its supporting components using containers.
* The container becomes the unit for distributing and testing your application.
* When you're ready, deploy your application into your production environment, as a container or an orchestrated service. This works the same whether your production environment is a local data center, a cloud provider, or a hybrid of the two.

-- [Docker Documentation](https://docs.docker.com/get-started/docker-overview/#the-docker-platform)

## Usage

What can I use Docker for?

### Fast, consistent delivery of your applications

Docker streamlines the development lifecycle by allowing developers to work in standardized environments using *local containers* which provide your applications and services. Containers are great for continuous integration and continuous delivery (CI/CD) workflows.

Consider the following example scenario:

* Your developers write code locally and share their work with their colleagues using Docker containers.
* They use Docker to push their applications into a test environment and run automated and manual tests.
* When developers find bugs, they can fix them in the development environment and redeploy them to the test environment for testing and validation.
* When testing is complete, getting the fix to the customer is as simple as pushing the updated image to the production environment.

### Responsive deployment and scaling

Docker's container-based platform allows for *highly portable workloads*. Docker containers can run on a developer's local laptop, on physical or virtual machines in a data center, on cloud providers, or in a mixture of environments.

Docker's portability and lightweight nature also make it easy to *dynamically manage workloads*, scaling up or tearing down applications and services as business needs dictate, in near real time.

### Running more workloads on the same hardware

Docker is lightweight and fast. It provides a viable, cost-effective alternative to hypervisor-based virtual machines, so you can use more of your server capacity to achieve your business goals. Docker is perfect for high density environments and for small and medium deployments where you need to do more with fewer resources.

-- [Docker Documentation](https://docs.docker.com/get-started/docker-overview/#what-can-i-use-docker-for)

## Operation

Docker can use different interfaces to access virtualization features of the Linux kernel.

Docker can *package an application and its dependencies in a virtual container that can run on any Linux, Windows, or macOS computer*. This enables the application to run in a variety of locations, such as on-premises, in public (see decentralized computing, distributed computing, and cloud computing) or private cloud. When running on Linux, Docker uses the resource isolation features of the Linux kernel (such as **cgroups** and **kernel namespaces**) and a union-capable file system (such as OverlayFS) to allow containers to run within a single Linux instance, avoiding the overhead of starting and maintaining virtual machines. Docker on macOS uses a Linux virtual machine to run the containers.

*Because Docker containers are lightweight, a single server or virtual machine can run several containers simultaneously.* A 2018 analysis found that a typical Docker use case involves running eight containers per host, and that a quarter of analyzed organizations run 18 or more per host. It can also be installed on a single board computer like the Raspberry Pi.

The Linux kernel's support for *namespaces* mostly isolates an application's view of the operating environment, including process trees, network, user IDs and mounted file systems, while the kernel's *cgroups* provide resource limiting for memory and CPU. Since version 0.9, Docker includes its own component (called **libcontainer**) to use virtualization facilities provided directly by the Linux kernel, in addition to using abstracted virtualization interfaces via *libvirt*, *LXC* and *systemd-nspawn*.

Docker implements a high-level API to provide lightweight containers that run processes in isolation.

![Docker can use different interfaces to access virtualization features of the Linux kernel.](https://upload.wikimedia.org/wikipedia/commons/0/09/Docker-linux-interfaces.svg)

-- [Wikipedia](https://en.wikipedia.org/wiki/Docker_(software)#Operation)

## Components

The Docker software as a service offering consists of three components:

* **Software**:
    * **The Docker daemon**, called **`dockerd`**, is a persistent process that manages Docker containers and handles container objects. The daemon listens for requests sent via the Docker Engine API.
    * **The Docker client** program, called **`docker`**, provides a command-line interface (CLI) that allows users to interact with Docker daemons.
* **Objects**: Docker objects are various entities used to assemble an application in Docker. The main classes of Docker objects are images, containers, and services.
    * A **Docker container** is a standardized, encapsulated environment that runs applications. A container is managed using the Docker API or CLI.
    * A **Docker image** is a read-only template used to build containers. Images are used to store and ship applications.
    * A **Docker service** allows containers to be scaled across multiple Docker daemons. The result is known as a **swarm**, a set of cooperating daemons that communicate through the Docker API.
* **Registries**: A **Docker registry** is a repository for Docker images. Docker clients connect to registries to download ("`pull`") images for use or upload ("`push`") images that they have built. Registries can be public or private. The main public registry is **Docker Hub**. Docker Hub is the default registry where Docker looks for images. Docker registries also allow the creation of notifications based on events.

-- [Wikipedia](https://en.wikipedia.org/wiki/Docker_(software)#Components)

## Architecture

Docker uses a client-server architecture. The Docker client talks to the Docker daemon, which does the heavy lifting of building, running, and distributing your Docker containers. The Docker client and daemon can run on the same system, or you can connect a Docker client to a remote Docker daemon. The Docker client and daemon communicate using a REST API, over UNIX sockets or a network interface. Another Docker client is Docker Compose, that lets you work with applications consisting of a set of containers.

![Docker architecture schema](https://docs.docker.com/get-started/images/docker-architecture.webp)

### The Docker daemon

The **Docker daemon** (**`dockerd`**) listens for Docker API requests and manages Docker objects such as images, containers, networks, and volumes. A daemon can also communicate with other daemons to manage Docker services.

### The Docker client

The **Docker client** (**`docker`**) is the primary way that many Docker users interact with Docker. When you use commands such as docker run, the client sends these commands to dockerd, which carries them out. The docker command uses the Docker API. The Docker client can communicate with more than one daemon.

### Docker Desktop

**Docker Desktop** is an easy-to-install application for your Mac, Windows or Linux environment that enables you to build and share containerized applications and microservices. Docker Desktop includes the **Docker daemon** (dockerd), the **Docker client** (docker), **Docker Compose**, **Docker Content Trust**, **Kubernetes**, and **Credential Helper**. For more information, see Docker Desktop.

### Docker registries

A **Docker registry** stores Docker images. **Docker Hub** is a public registry that anyone can use, and Docker looks for images on Docker Hub by default. You can even run your own private registry.

When you use the `docker pull` or `docker run` commands, Docker pulls the required images from your configured registry. When you use the `docker push` command, Docker pushes your image to your configured registry.

### Docker objects

When you use Docker, you are creating and using images, containers, networks, volumes, plugins, and other objects. This section is a brief overview of some of those objects.

#### Images

An **image** is *a read-only template with instructions for creating a Docker container*. *Often, an image is based on another image, with some additional customization.* For example, you may build an image which is based on the ubuntu image, but installs the Apache web server and your application, as well as the configuration details needed to make your application run.

You might create your own images or you might only use those created by others and published in a registry. To build your own image, you create a **Dockerfile** with a simple syntax for defining the steps needed to create the image and run it. *Each instruction in a Dockerfile creates a layer in the image. When you change the Dockerfile and rebuild the image, only those layers which have changed are rebuilt.* This is part of what makes images so lightweight, small, and fast, when compared to other virtualization technologies.

#### Containers

A **container** is *a runnable instance of an image*. You can create, start, stop, move, or delete a container using the Docker API or CLI. You can connect a container to one or more networks, attach storage to it, or even create a new image based on its current state.

By default, a container is relatively well isolated from other containers and its host machine. You can control how isolated a container's network, storage, or other underlying subsystems are from other containers or from the host machine.

A container is defined by its image as well as any configuration options you provide to it when you create or start it. When a container is removed, any changes to its state that aren't stored in persistent storage disappear.

-- [Docker Documentation](https://docs.docker.com/get-started/docker-overview/#docker-architecture)

## The underlying technology

Docker is written in the **Go** programming language and takes advantage of several features of the Linux kernel to deliver its functionality. Docker uses a technology called namespaces to provide the isolated workspace called the container. When you run a container, Docker creates a set of namespaces for that container.

These namespaces provide a layer of isolation. Each aspect of a container runs in a separate namespace and its access is limited to that namespace.

-- [Docker Documentation](https://docs.docker.com/get-started/docker-overview/#the-underlying-technology)
