# [Managing images](https://docs.docker.com/reference/cli/docker/image)

## [Displaying all commands managing images](https://docs.docker.com/reference/cli/docker/image)

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

## [Displaying images](https://docs.docker.com/reference/cli/docker/image/ls)

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

For example, the command `docker images --filter reference=alpine` filters the output of the docker images command to only print alpine images.

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

## [Displayed information about an image](https://docs.docker.com/reference/cli/docker/inspect/)

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

## [Showing history of an image](https://docs.docker.com/reference/cli/docker/image/history)

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

## [Loading image](https://docs.docker.com/reference/cli/docker/image/load)

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

## [Importing image](https://docs.docker.com/reference/cli/docker/image/import)

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

## [Removing image](https://docs.docker.com/reference/cli/docker/image/rm)

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

## [Removing unused images](https://docs.docker.com/reference/cli/docker/image/prune)

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

## [Downloading an image from a registry](https://docs.docker.com/reference/cli/docker/image/pull)

```
docker image pull [OPTIONS] NAME[:TAG|@DIGEST]
```

*Docker Hub*

Most of your images will be created on top of a base image from the Docker Hub registry.

Docker Hub contains many pre-built images that you can pull and try without needing to define and configure your own.

To download a particular image, or set of images (i.e., a repository), use `docker pull`.

-- [Docker Documentation](https://docs.docker.com/reference/cli/docker/image/pull/#description)

**Aliases**

```
docker pull
```

**Options**

```
  -a, --all-tags                Download all tagged images in the repository
      --disable-content-trust   Skip image verification (default true)
      --platform string         Set platform if server is multi-platform capable
  -q, --quiet                   Suppress verbose output
```

**Examples**

```
docker image pull fedora
```

```
Using default tag: latest
latest: Pulling from library/fedora
7b060d214eb0: Pull complete
Digest: sha256:3da64cb89971a1cdbc6046e307eeebcb54f7281c0a606ee48d9995473f6b88d5
Status: Downloaded newer image for fedora:latest
docker.io/library/fedora:latest
```

```
docker image pull fedora:rawhide
```

```
rawhide: Pulling from library/fedora
d1e07e1d972b: Pull complete
Digest: sha256:af660adb8de42682b494c7d102860c155466ba61cd850a8420e1ffad1764b1b7
Status: Downloaded newer image for fedora:rawhide
docker.io/library/fedora:rawhide
```

```
docker image pull --all-tags debian
```

```
10: Pulling from library/debian
3892befd2c3f: Pull complete
Digest: sha256:58ce6f1271ae1c8a2006ff7d3e54e9874d839f573d8009c20154ad0f2fb0a225
10-slim: Pulling from library/debian
b338562f40a7: Pull complete
Digest: sha256:bb3dc79fddbca7e8903248ab916bb775c96ec61014b3d02b4f06043b604726dc
10.0: Pulling from library/debian
4ae16bd47783: Pull complete
Digest: sha256:2f04d3d33b6027bb74ecc81397abe780649ec89f1a2af18d7022737d0482cefe
Head "https://registry-1.docker.io/v2/library/debian/manifests/10.0-slim": net/http: TLS handshake timeout
```

## [Tagging images](https://docs.docker.com/reference/cli/docker/image/tag)

```
docker image tag SOURCE_IMAGE[:TAG] TARGET_IMAGE[:TAG]
```

**Aliases**

```
docker tag
```

***Image tags***

A Docker image reference consists of several components that describe where the image is stored and its identity. These components are:

```
[HOST[:PORT]/]NAMESPACE/REPOSITORY[:TAG]
```

* **HOST**:
    Specifies the registry location where the image resides. If omitted, Docker defaults to Docker Hub (docker.io).
* **PORT**:
    An optional port number for the registry, if necessary (for example, :5000).
* **NAMESPACE/REPOSITORY**:
    The namespace (optional) usually represents a user or organization. The repository is required and identifies the specific image. If the namespace is omitted, Docker defaults to library, the namespace reserved for Docker Official Images.
* **TAG**:
    An optional identifier used to specify a particular version or variant of the image. If no tag is provided, Docker defaults to latest.

*Example image references*

```
example.com:5000/team/my-app:2.0
```
* **Host**: example.com
* **Port**: 5000
* **Namespace**: team
* **Repository**: my-app
* **Tag**: 2.0

```
alpine
```
* **Host**: docker.io (default)
* **Namespace**: library (default)
* **Repository**: alpine
* **Tag**: latest (default)

-- [Docker Documentation](https://docs.docker.com/reference/cli/docker/image/tag/#description)

**Examples**

```
docker image tag ubuntu:latest katheroine/ubuntu:latest
```

```
docker tag fdc54e0833b1 katheroine/fedora:rawhide
```

## [Uploading an image to a registry](https://docs.docker.com/reference/cli/docker/image/push)

```
docker image push [OPTIONS] NAME[:TAG]
```

*Docker Hub*

Use docker image push to share your images to the Docker Hub registry or to a self-hosted one.

Refer to the docker image tag reference for more information about valid image and tag names.

Killing the docker image push process, for example by pressing CTRL-c while it is running in a terminal, terminates the push operation.

Progress bars are shown during docker push, which show the uncompressed size. The actual amount of data that's pushed will be compressed before sending, so the uploaded size will not be reflected by the progress bar.

Registry credentials are managed by `docker login`.

-- [Docker Documentation](https://docs.docker.com/reference/cli/docker/image/push/#description)

**Aliases**

```
docker push
```

**Options**

```
  -a, --all-tags                Push all tags of an image to the repository
      --disable-content-trust   Skip image signing (default true)
      --platform string         Push a platform-specific manifest as a single-platform image to the registry.
                                Image index won't be pushed, meaning that other manifests, including attestations won't be preserved.
                                'os[/arch[/variant]]': Explicit platform (eg. linux/amd64)
  -q, --quiet                   Suppress verbose output
```

**Examples**

```
docker image push katheroine/ubuntu:latest
```

```
The push refers to repository [docker.io/katheroine/ubuntu]
cd9664b1462e: Mounted from library/ubuntu
latest: digest: sha256:1b74ddb96240d6db9ef2a067493998e61f7965d22b76166d04dd3662818bbfdb size: 529
```
