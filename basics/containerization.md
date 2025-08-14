# Containerization

## What is the containerization

In software engineering, [**containerization**](https://en.wikipedia.org/wiki/Containerization_(computing)) is *operating-system-level virtualization or application-level virtualization* over multiple network resources so that software applications can run in isolated user spaces called *containers* in any cloud or non-cloud environment, regardless of type or vendor. The term "container" is overloaded, and it is important to ensure that the intended definition aligns with the audience's understanding.

-- [Wikipedia](https://en.wikipedia.org/wiki/Containerization_(computing))

[**Containerization**](https://www.ibm.com/think/topics/containerization) is the *packaging of software code with just the operating system (OS) libraries and dependencies required to run the code* to create a single lightweight executable - called a *container* - that runs consistently on any infrastructure.

More portable and resource-efficient than virtual machines (VMs), containers have become the de facto compute units of modern cloud-native applications.

**Containerization** allows developers to create and deploy applications faster and more securely. With traditional methods, developers write code in a specific computing environment, which, when transferred to a new location, often results in bugs and errors. For instance, this can happen when a developer transfers code from a desktop computer to a VM or from a Linux to a Windows operating system. Containerization eliminates this problem by *bundling the application code with the related configuration files, libraries and dependencies required for it to run*. This single software package or "container" is abstracted away from the host operating system. Hence, it stands alone and becomes portable - able to run across any platform or cloud, free of issues.

-- [IBM Webpage](https://www.ibm.com/think/topics/containerization)

A **container** is a standard unit of software that packages up code and all its dependencies so the application runs quickly and reliably from one computing environment to another.

-- [Docker Resources](https://www.docker.com/resources/what-container)

Each **container** is basically a *fully functional and portable cloud or non-cloud computing environment* surrounding the application and keeping it independent of other environments running in parallel. Individually, *each container simulates a different software application and runs isolated processes* by bundling related configuration files, libraries and dependencies. But, collectively, multiple containers share a common operating system kernel (OS).

-- [Wikipedia](https://en.wikipedia.org/wiki/Containerization_(computing)#Usage)

**Containers** are "lightweight", meaning they share the machine's operating system kernel and do not require the overhead of associating an operating system within each application. Containers are inherently smaller in capacity than VMs and require less start-up time. This capability allows far more containers to run on the same compute capacity as a single VM. This capability drives higher server efficiencies and, in turn, reduces server and licensing costs.

Most importantly, containerization enables applications to be "written once and run anywhere" across on-premises data center, hybrid cloud and multicloud environments.

This portability speeds development, prevents cloud vendor lock-in and offers other notable benefits like fault isolation, ease of management, simplified security and more.

-- [IBM Webpage](https://www.ibm.com/think/topics/containerization)

The concept of containerization and process isolation is decades old. However, the emergence in 2013 of the open-source Docker - an industry standard for containers with simple developer tools and a universal packaging approach - accelerated the adoption of this technology. Today, organizations increasingly use containerization to create new applications and modernize existing applications for the cloud.

-- [IBM Webpage](https://www.ibm.com/think/topics/containerization)

In recent times, containerization technology has been widely adopted by cloud computing platforms like Amazon Web Services, Microsoft Azure, Google Cloud Platform, and IBM Cloud. Containerization has also been pursued by the U.S. Department of Defense as a way of more rapidly developing and fielding software updates, with first application in its F-22 air superiority fighter.

-- [Wikipedia](https://en.wikipedia.org/wiki/Containerization_(computing)#Usage)

According to a report from Forrester1, 74 percent of US infrastructure decision-makers say that their firms are adopting containers within a platform as a service (PaaS) in an on-premises or public cloud environment.

-- [IBM Webpage](https://www.ibm.com/think/topics/containerization)

## Types of containers

* OS containers
* Application containers

-- [Wikipedia](https://en.wikipedia.org/wiki/Containerization_(computing)#Types_of_containers)

## Container management, orchestration, clustering

Container orchestration or container management is mostly used in the context of application containers. Implementations providing such orchestration include *Kubernetes* and *Docker swarm*.

-- [Wikipedia](https://en.wikipedia.org/wiki/Containerization_(computing)#Container_cluster_management)

## Containerization architecture

Containerization architecture consists of four essential component layers.

* **Underlying IT infrastructure**: The underlying IT infrastructure is a base layer that includes the physical compute resources (for example, desktop computer, bare-metal server).

* **Host operating system**: This layer runs on the physical or virtual machine. The OS manages system resources and provides a runtime environment for container engines.

* **Container image**: Also referred to as a runtime engine, the container engine provides the execution environment for container images (*read-only templates containing instructions for creating a container*). Container engines run on top of the host OS and virtualize the resources for containerized applications.

* **Containerized applications**: This final layer consists of the software applications run in containers.

-- [IBM Webpage](https://www.ibm.com/think/topics/containerization)












