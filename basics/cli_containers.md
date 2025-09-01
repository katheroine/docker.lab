# [Managing containers](https://docs.docker.com/reference/cli/docker/container)

## [Displaying all commands managing containers](https://docs.docker.com/reference/cli/docker/container)

```
docker container
```

```
Usage:  docker container COMMAND

Manage containers

Commands:
  attach      Attach local standard input, output, and error streams to a running container
  commit      Create a new image from a container's changes
  cp          Copy files/folders between a container and the local filesystem
  create      Create a new container
  diff        Inspect changes to files or directories on a container's filesystem
  exec        Execute a command in a running container
  export      Export a container's filesystem as a tar archive
  inspect     Display detailed information on one or more containers
  kill        Kill one or more running containers
  logs        Fetch the logs of a container
  ls          List containers
  pause       Pause all processes within one or more containers
  port        List port mappings or a specific mapping for the container
  prune       Remove all stopped containers
  rename      Rename a container
  restart     Restart one or more containers
  rm          Remove one or more containers
  run         Create and run a new container from an image
  start       Start one or more stopped containers
  stats       Display a live stream of container(s) resource usage statistics
  stop        Stop one or more running containers
  top         Display the running processes of a container
  unpause     Unpause all processes within one or more containers
  update      Update configuration of one or more containers
  wait        Block until one or more containers stop, then print their exit codes

Run 'docker container COMMAND --help' for more information on a command.
```

## [Displaying containers](https://docs.docker.com/reference/cli/docker/container/ls)

```
docker container ls [OPTIONS]
```

**Aliases**

```
docker container list
```

```
docker container ps
```

```
docker ps
```

**Options**

```
  -a, --all             Show all containers (default shows just running)
  -f, --filter filter   Filter output based on conditions provided
      --format string   Format output using a custom template:
                        'table':            Print output in table format with column headers (default)
                        'table TEMPLATE':   Print output in table format using the given Go template
                        'json':             Print in JSON format
                        'TEMPLATE':         Print output using the given Go template.
                        Refer to https://docs.docker.com/go/formatting/ for more information about formatting output with templates
  -n, --last int        Show n last created containers (includes all states) (default -1)
  -l, --latest          Show the latest created container (includes all states)
      --no-trunc        Don't truncate output
  -q, --quiet           Only display container IDs
  -s, --size            Display total file sizes
```

By default, docker lists only currently running containers. To display all existing containers the `-a` option is needed.

*Filtering results*

You can use the `--filter` flag to scope your commands. When filtering, the commands only include entries that match the pattern you specify.

The `--filter` flag expects a `key`-`value` pair separated by an operator.

```
docker COMMAND --filter "KEY=VALUE"
```

The key represents the field that you want to filter on. The value is the pattern that the specified field must match. The operator can be either equals (`=`) or not equals (`!=`).

-- [Docker Documentation](https://docs.docker.com/engine/cli/filter)

**Examples**

* Displaying running containers

```console
$ docker container ls
CONTAINER ID   IMAGE                      COMMAND                  CREATED         STATUS         PORTS     NAMES
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   5 seconds ago   Up 5 seconds   80/tcp    keen_herschel
```

* Dispalying all containers

```console
$ docker container ls -a
CONTAINER ID   IMAGE                      COMMAND                  CREATED              STATUS                      PORTS     NAMES
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   About a minute ago   Up About a minute           80/tcp    keen_herschel
53b03c3045a2   ubuntu                     "/bin/bash"              59 minutes ago       Exited (0) 59 minutes ago             sweet_driscoll
```

* Displaying filtered out containers

```console
$ docker container ls -a -f "status=exited"
CONTAINER ID   IMAGE     COMMAND       CREATED             STATUS                         PORTS     NAMES
53b03c3045a2   ubuntu    "/bin/bash"   About an hour ago   Exited (0) About an hour ago             sweet_driscoll
```

## [Displayed information about a container](https://docs.docker.com/reference/cli/docker/container/inspect)

```
docker container inspect [OPTIONS] CONTAINER [CONTAINER...]
```

**Options**

```
  -f, --format string   Format output using a custom template:
                        'json':             Print in JSON format
                        'TEMPLATE':         Print output using the given Go template.
                        Refer to https://docs.docker.com/go/formatting/ for more information about formatting output with templates
  -s, --size            Display total file sizes
```

**Examples**

```console
$ docker ps -a
CONTAINER ID   IMAGE                      COMMAND                  CREATED        STATUS                      PORTS     NAMES
2a8f7213080a   ubuntu                     "/bin/bash"              46 hours ago   Created                               brave_wozniak
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   2 days ago     Exited (0) 47 hours ago               keen_herschel
53b03c3045a2   ubuntu                     "/bin/bash"              2 days ago     Exited (0) 2 days ago                 sweet_driscoll
```

```console
$ docker container inspect sweet_driscoll
[
    {
        "Id": "53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623",
        "Created": "2025-08-21T08:23:10.97554531Z",
        "Path": "/bin/bash",
        "Args": [],
        "State": {
            "Status": "exited",
            "Running": false,
            "Paused": false,
            "Restarting": false,
            "OOMKilled": false,
            "Dead": false,
            "Pid": 0,
            "ExitCode": 0,
            "Error": "",
            "StartedAt": "2025-08-21T08:23:31.646944186Z",
            "FinishedAt": "2025-08-21T08:23:32.077484747Z"
        },
        "Image": "sha256:e0f16e6366fef4e695b9f8788819849d265cde40eb84300c0147a6e5261d2750",
        "ResolvConfPath": "/var/lib/docker/containers/53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623/resolv.conf",
        "HostnamePath": "/var/lib/docker/containers/53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623/hostname",
        "HostsPath": "/var/lib/docker/containers/53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623/hosts",
        "LogPath": "/var/lib/docker/containers/53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623/53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623-json.log",
        "Name": "/sweet_driscoll",
        "RestartCount": 0,
        "Driver": "overlay2",
        "Platform": "linux",
        "MountLabel": "",
        "ProcessLabel": "",
        "AppArmorProfile": "docker-default",
        "ExecIDs": null,
        "HostConfig": {
            "Binds": null,
            "ContainerIDFile": "",
            "LogConfig": {
                "Type": "json-file",
                "Config": {}
            },
            "NetworkMode": "bridge",
            "PortBindings": {},
            "RestartPolicy": {
                "Name": "no",
                "MaximumRetryCount": 0
            },
            "AutoRemove": false,
            "VolumeDriver": "",
            "VolumesFrom": null,
            "ConsoleSize": [
                33,
                274
            ],
            "CapAdd": null,
            "CapDrop": null,
            "CgroupnsMode": "host",
            "Dns": [],
            "DnsOptions": [],
            "DnsSearch": [],
            "ExtraHosts": null,
            "GroupAdd": null,
            "IpcMode": "private",
            "Cgroup": "",
            "Links": null,
            "OomScoreAdj": 0,
            "PidMode": "",
            "Privileged": false,
            "PublishAllPorts": false,
            "ReadonlyRootfs": false,
            "SecurityOpt": null,
            "UTSMode": "",
            "UsernsMode": "",
            "ShmSize": 67108864,
            "Runtime": "runc",
            "Isolation": "",
            "CpuShares": 0,
            "Memory": 0,
            "NanoCpus": 0,
            "CgroupParent": "",
            "BlkioWeight": 0,
            "BlkioWeightDevice": [],
            "BlkioDeviceReadBps": [],
            "BlkioDeviceWriteBps": [],
            "BlkioDeviceReadIOps": [],
            "BlkioDeviceWriteIOps": [],
            "CpuPeriod": 0,
            "CpuQuota": 0,
            "CpuRealtimePeriod": 0,
            "CpuRealtimeRuntime": 0,
            "CpusetCpus": "",
            "CpusetMems": "",
            "Devices": [],
            "DeviceCgroupRules": null,
            "DeviceRequests": null,
            "MemoryReservation": 0,
            "MemorySwap": 0,
            "MemorySwappiness": null,
            "OomKillDisable": false,
            "PidsLimit": null,
            "Ulimits": [],
            "CpuCount": 0,
            "CpuPercent": 0,
            "IOMaximumIOps": 0,
            "IOMaximumBandwidth": 0,
            "MaskedPaths": [
                "/proc/asound",
                "/proc/acpi",
                "/proc/interrupts",
                "/proc/kcore",
                "/proc/keys",
                "/proc/latency_stats",
                "/proc/timer_list",
                "/proc/timer_stats",
                "/proc/sched_debug",
                "/proc/scsi",
                "/sys/firmware",
                "/sys/devices/virtual/powercap",
                "/sys/devices/system/cpu/cpu0/thermal_throttle",
                "/sys/devices/system/cpu/cpu1/thermal_throttle",
                "/sys/devices/system/cpu/cpu2/thermal_throttle",
                "/sys/devices/system/cpu/cpu3/thermal_throttle"
            ],
            "ReadonlyPaths": [
                "/proc/bus",
                "/proc/fs",
                "/proc/irq",
                "/proc/sys",
                "/proc/sysrq-trigger"
            ]
        },
        "GraphDriver": {
            "Data": {
                "ID": "53b03c3045a24f7af222dc3b2ae611dd95ad283085cf06ec0b73d2ab50cce623",
                "LowerDir": "/var/lib/docker/overlay2/70c0bead8eb39444682c40dac2d93b572dd3f70787c9fbdaf678f2ea8322aaf1-init/diff:/var/lib/docker/overlay2/4498da4ac60983a4742ebc410ff49c2369ca7e3ce310ba57e1311296e2feee84/diff",
                "MergedDir": "/var/lib/docker/overlay2/70c0bead8eb39444682c40dac2d93b572dd3f70787c9fbdaf678f2ea8322aaf1/merged",
                "UpperDir": "/var/lib/docker/overlay2/70c0bead8eb39444682c40dac2d93b572dd3f70787c9fbdaf678f2ea8322aaf1/diff",
                "WorkDir": "/var/lib/docker/overlay2/70c0bead8eb39444682c40dac2d93b572dd3f70787c9fbdaf678f2ea8322aaf1/work"
            },
            "Name": "overlay2"
        },
        "Mounts": [],
        "Config": {
            "Hostname": "53b03c3045a2",
            "Domainname": "",
            "User": "",
            "AttachStdin": false,
            "AttachStdout": true,
            "AttachStderr": true,
            "Tty": false,
            "OpenStdin": false,
            "StdinOnce": false,
            "Env": [
                "PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
            ],
            "Cmd": [
                "/bin/bash"
            ],
            "Image": "ubuntu",
            "Volumes": null,
            "WorkingDir": "",
            "Entrypoint": null,
            "OnBuild": null,
            "Labels": {
                "org.opencontainers.image.ref.name": "ubuntu",
                "org.opencontainers.image.version": "24.04"
            }
        },
        "NetworkSettings": {
            "Bridge": "",
            "SandboxID": "",
            "SandboxKey": "",
            "Ports": {},
            "HairpinMode": false,
            "LinkLocalIPv6Address": "",
            "LinkLocalIPv6PrefixLen": 0,
            "SecondaryIPAddresses": null,
            "SecondaryIPv6Addresses": null,
            "EndpointID": "",
            "Gateway": "",
            "GlobalIPv6Address": "",
            "GlobalIPv6PrefixLen": 0,
            "IPAddress": "",
            "IPPrefixLen": 0,
            "IPv6Gateway": "",
            "MacAddress": "",
            "Networks": {
                "bridge": {
                    "IPAMConfig": null,
                    "Links": null,
                    "Aliases": null,
                    "MacAddress": "",
                    "DriverOpts": null,
                    "GwPriority": 0,
                    "NetworkID": "5fd30f5f0941816da1e54390f32454bc535a02c25b951cd1b2fd25361f5c2c87",
                    "EndpointID": "",
                    "Gateway": "",
                    "IPAddress": "",
                    "IPPrefixLen": 0,
                    "IPv6Gateway": "",
                    "GlobalIPv6Address": "",
                    "GlobalIPv6PrefixLen": 0,
                    "DNSNames": null
                }
            }
        }
    }
]
```

## [Showing logs of a container](https://docs.docker.com/reference/cli/docker/container/logs)

```
docker container logs [OPTIONS] CONTAINER
```

**Aliases**

```
docker logs
```

**Options**

```
      --details        Show extra details provided to logs
  -f, --follow         Follow log output
      --since string   Show logs since timestamp (e.g. "2013-01-02T13:23:37Z") or relative (e.g. "42m" for 42 minutes)
  -n, --tail string    Number of lines to show from the end of the logs (default "all")
  -t, --timestamps     Show timestamps
      --until string   Show logs before a timestamp (e.g. "2013-01-02T13:23:37Z") or relative (e.g. "42m" for 42 minutes)
```

**Examples**

```console
$ docker ps -a
CONTAINER ID   IMAGE                      COMMAND                  CREATED        STATUS                      PORTS     NAMES
2a8f7213080a   ubuntu                     "/bin/bash"              46 hours ago   Created                               brave_wozniak
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   2 days ago     Exited (0) 47 hours ago               keen_herschel
53b03c3045a2   ubuntu                     "/bin/bash"              2 days ago     Exited (0) 2 days ago                 sweet_driscoll
```

```console
$ docker container logs keen_herschel
/docker-entrypoint.sh: /docker-entrypoint.d/ is not empty, will attempt to perform configuration
/docker-entrypoint.sh: Looking for shell scripts in /docker-entrypoint.d/
/docker-entrypoint.sh: Launching /docker-entrypoint.d/10-listen-on-ipv6-by-default.sh
10-listen-on-ipv6-by-default.sh: info: Getting the checksum of /etc/nginx/conf.d/default.conf
10-listen-on-ipv6-by-default.sh: info: Enabled listen on IPv6 in /etc/nginx/conf.d/default.conf
/docker-entrypoint.sh: Sourcing /docker-entrypoint.d/15-local-resolvers.envsh
/docker-entrypoint.sh: Launching /docker-entrypoint.d/20-envsubst-on-templates.sh
/docker-entrypoint.sh: Launching /docker-entrypoint.d/30-tune-worker-processes.sh
/docker-entrypoint.sh: Configuration complete; ready for start up
2025/08/21 09:21:29 [notice] 1#1: using the "epoll" event method
2025/08/21 09:21:29 [notice] 1#1: nginx/1.29.0
2025/08/21 09:21:29 [notice] 1#1: built by gcc 14.2.0 (Alpine 14.2.0)
2025/08/21 09:21:29 [notice] 1#1: OS: Linux 5.4.0-216-generic
2025/08/21 09:21:29 [notice] 1#1: getrlimit(RLIMIT_NOFILE): 1048576:1048576
2025/08/21 09:21:29 [notice] 1#1: start worker processes
2025/08/21 09:21:29 [notice] 1#1: start worker process 31
2025/08/21 09:21:29 [notice] 1#1: start worker process 32
2025/08/21 09:21:29 [notice] 1#1: start worker process 33
2025/08/21 09:21:29 [notice] 1#1: start worker process 34
```

## [Displaying top processes running on a container](https://docs.docker.com/reference/cli/docker/container/top)

```
docker container top CONTAINER [ps OPTIONS]
```

**Aliases**

```
docker top
```

**Examples**

```console
$ docker ps -a
CONTAINER ID   IMAGE                      COMMAND                  CREATED        STATUS                      PORTS     NAMES
2a8f7213080a   ubuntu                     "/bin/bash"              46 hours ago   Created                               brave_wozniak
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   2 days ago     Exited (0) 47 hours ago               keen_herschel
53b03c3045a2   ubuntu                     "/bin/bash"              2 days ago     Exited (0) 2 days ago                 sweet_driscoll
$ docker start keen_herschel
$ docker ps
CONTAINER ID   IMAGE                      COMMAND                  CREATED      STATUS         PORTS     NAMES
98a99f1d450e   docker/welcome-to-docker   "/docker-entrypoint.…"   2 days ago   Up 8 seconds   80/tcp    keen_herschel
```

```console
$ docker container top keen_herschel
UID                 PID                 PPID                C                   STIME               TTY                 TIME                CMD
root                559097              559074              0                   11:15               ?                   00:00:00            nginx: master process nginx -g daemon off;
systemd+            559147              559097              0                   11:15               ?                   00:00:00            nginx: worker process
systemd+            559148              559097              0                   11:15               ?                   00:00:00            nginx: worker process
systemd+            559149              559097              0                   11:15               ?                   00:00:00            nginx: worker process
systemd+            559150              559097              0                   11:15               ?                   00:00:00            nginx: worker process
```

## [Creating a container](https://docs.docker.com/reference/cli/docker/container/create)

```
docker container create [OPTIONS] IMAGE [COMMAND] [ARG...]
```

The `docker container` create (or shorthand: `docker create`) command creates a new container from the specified image, without starting it.

When creating a container, the Docker daemon creates a writeable container layer over the specified image and prepares it for running the specified command. The container ID is then printed to STDOUT. This is similar to `docker run -d` except the container is never started. You can then use the docker container start (or shorthand: `docker start`) command to start the container at any point.

This is useful when you want to set up a container configuration ahead of time so that it's ready to start when you need it. The initial status of the new container is created.

The `docker create` command shares most of its options with the `docker run` command (which performs a `docker create` before starting it).

-- [Docker Documentation](https://docs.docker.com/reference/cli/docker/container/create/#description)

**Aliases**

```
docker create
```

**Options**

```
      --add-host list                    Add a custom host-to-IP mapping (host:ip)
      --annotation map                   Add an annotation to the container (passed through to the OCI runtime) (default map[])
  -a, --attach list                      Attach to STDIN, STDOUT or STDERR
      --blkio-weight uint16              Block IO (relative weight), between 10 and 1000, or 0 to disable (default 0)
      --blkio-weight-device list         Block IO weight (relative device weight) (default [])
      --cap-add list                     Add Linux capabilities
      --cap-drop list                    Drop Linux capabilities
      --cgroup-parent string             Optional parent cgroup for the container
      --cgroupns string                  Cgroup namespace to use (host|private)
                                         'host':    Run the container in the Docker host's cgroup namespace
                                         'private': Run the container in its own private cgroup namespace
                                         '':        Use the cgroup namespace as configured by the
                                                    default-cgroupns-mode option on the daemon (default)
      --cidfile string                   Write the container ID to the file
      --cpu-period int                   Limit CPU CFS (Completely Fair Scheduler) period
      --cpu-quota int                    Limit CPU CFS (Completely Fair Scheduler) quota
      --cpu-rt-period int                Limit CPU real-time period in microseconds
      --cpu-rt-runtime int               Limit CPU real-time runtime in microseconds
  -c, --cpu-shares int                   CPU shares (relative weight)
      --cpus decimal                     Number of CPUs
      --cpuset-cpus string               CPUs in which to allow execution (0-3, 0,1)
      --cpuset-mems string               MEMs in which to allow execution (0-3, 0,1)
      --device list                      Add a host device to the container
      --device-cgroup-rule list          Add a rule to the cgroup allowed devices list
      --device-read-bps list             Limit read rate (bytes per second) from a device (default [])
      --device-read-iops list            Limit read rate (IO per second) from a device (default [])
      --device-write-bps list            Limit write rate (bytes per second) to a device (default [])
      --device-write-iops list           Limit write rate (IO per second) to a device (default [])
      --disable-content-trust            Skip image verification (default true)
      --dns list                         Set custom DNS servers
      --dns-option list                  Set DNS options
      --dns-search list                  Set custom DNS search domains
      --domainname string                Container NIS domain name
      --entrypoint string                Overwrite the default ENTRYPOINT of the image
  -e, --env list                         Set environment variables
      --env-file list                    Read in a file of environment variables
      --expose list                      Expose a port or a range of ports
      --gpus gpu-request                 GPU devices to add to the container ('all' to pass all GPUs)
      --group-add list                   Add additional groups to join
      --health-cmd string                Command to run to check health
      --health-interval duration         Time between running the check (ms|s|m|h) (default 0s)
      --health-retries int               Consecutive failures needed to report unhealthy
      --health-start-interval duration   Time between running the check during the start period (ms|s|m|h) (default 0s)
      --health-start-period duration     Start period for the container to initialize before starting health-retries countdown (ms|s|m|h) (default 0s)
      --health-timeout duration          Maximum time to allow one check to run (ms|s|m|h) (default 0s)
      --help                             Print usage
  -h, --hostname string                  Container host name
      --init                             Run an init inside the container that forwards signals and reaps processes
  -i, --interactive                      Keep STDIN open even if not attached
      --ip string                        IPv4 address (e.g., 172.30.100.104)
      --ip6 string                       IPv6 address (e.g., 2001:db8::33)
      --ipc string                       IPC mode to use
      --isolation string                 Container isolation technology
      --kernel-memory bytes              Kernel memory limit
  -l, --label list                       Set meta data on a container
      --label-file list                  Read in a line delimited file of labels
      --link list                        Add link to another container
      --link-local-ip list               Container IPv4/IPv6 link-local addresses
      --log-driver string                Logging driver for the container
      --log-opt list                     Log driver options
      --mac-address string               Container MAC address (e.g., 92:d0:c6:0a:29:33)
  -m, --memory bytes                     Memory limit
      --memory-reservation bytes         Memory soft limit
      --memory-swap bytes                Swap limit equal to memory plus swap: '-1' to enable unlimited swap
      --memory-swappiness int            Tune container memory swappiness (0 to 100) (default -1)
      --mount mount                      Attach a filesystem mount to the container
      --name string                      Assign a name to the container
      --network network                  Connect a container to a network
      --network-alias list               Add network-scoped alias for the container
      --no-healthcheck                   Disable any container-specified HEALTHCHECK
      --oom-kill-disable                 Disable OOM Killer
      --oom-score-adj int                Tune host's OOM preferences (-1000 to 1000)
      --pid string                       PID namespace to use
      --pids-limit int                   Tune container pids limit (set -1 for unlimited)
      --platform string                  Set platform if server is multi-platform capable
      --privileged                       Give extended privileges to this container
  -p, --publish list                     Publish a container's port(s) to the host
  -P, --publish-all                      Publish all exposed ports to random ports
      --pull string                      Pull image before creating ("always", "|missing", "never") (default "missing")
  -q, --quiet                            Suppress the pull output
      --read-only                        Mount the container's root filesystem as read only
      --restart string                   Restart policy to apply when a container exits (default "no")
      --rm                               Automatically remove the container and its associated anonymous volumes when it exits
      --runtime string                   Runtime to use for this container
      --security-opt list                Security Options
      --shm-size bytes                   Size of /dev/shm
      --stop-signal string               Signal to stop the container
      --stop-timeout int                 Timeout (in seconds) to stop a container
      --storage-opt list                 Storage driver options for the container
      --sysctl map                       Sysctl options (default map[])
      --tmpfs list                       Mount a tmpfs directory
  -t, --tty                              Allocate a pseudo-TTY
      --ulimit ulimit                    Ulimit options (default [])
      --use-api-socket                   Bind mount Docker API socket and required auth
  -u, --user string                      Username or UID (format: <name|uid>[:<group|gid>])
      --userns string                    User namespace to use
      --uts string                       UTS namespace to use
  -v, --volume list                      Bind mount a volume
      --volume-driver string             Optional volume driver for the container
      --volumes-from list                Mount volumes from the specified container(s)
  -w, --workdir string                   Working directory inside the container
```

***Mapping volumes***

```
docker container create -v /host/path:/container/path --name my_container ubuntu
```

**Examples**

* Creating container from an image
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container create ubuntu
2a8f7213080afa4be30b026d83a44af9f2a5890678f96a35f0dbd1b7e1548774
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS          PORTS     NAMES
2a8f7213080a   ubuntu    "/bin/bash"   5 seconds ago   Created                   brave_wozniak
```

* Creating container with defined name

```console
$ docker container create --name panda_wanda ubuntu
7f28aa0afc113e6571a7fe1301a27c12e070314f58c2a8ff3afbd0004c95feb6
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS          PORTS     NAMES
7f28aa0afc11   ubuntu    "/bin/bash"   8 seconds ago   Created                   panda_wanda
```

* Creating container with interactive mode

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS          PORTS     NAMES
7f28aa0afc11   ubuntu    "/bin/bash"   8 seconds ago    Created                   panda_wanda
```

```console
$ docker container create -i --name dynia_cedynia ubuntu
ef1d776ab8d0d85ce922b962f275612b68d550026d72ed4165066919f6fe0761
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS          PORTS     NAMES
ef1d776ab8d0   ubuntu    "/bin/bash"   5 seconds ago    Created                   dynia_cedynia
7f28aa0afc11   ubuntu    "/bin/bash"   13 seconds ago   Created                   panda_wanda
```

```console
$ docker start panda_wanda
panda_wanda
$ docker start dynia_cedynia
dynia_cedynia
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS         PORTS     NAMES
ef1d776ab8d0   ubuntu    "/bin/bash"   15 seconds ago   Up 3 seconds             dynia_cedynia
```

```console
$ docker stop dynia_cedynia
dynia_cedynia
$ docker start -i panda_wanda
$ docker start -i dynia_cedynia
^Ccontext canceled
```

* Creating container with interactive mode and pseudo-TTY allocated

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS         PORTS     NAMES
ef1d776ab8d0   ubuntu    "/bin/bash"   30 seconds ago   Up 2 minutes             dynia_cedynia
```

```console
$ docker container create -i -t --name ogorek_bonzurek fedora
cbcdf3bbf762e8cbc6e288b67ed8182efbda0dd86fc092f176a19006b5aeba35
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS          PORTS     NAMES
cbcdf3bbf762   fedora    "/bin/bash"   5 seconds ago    Created                   ogorek_bonzurek
ef1d776ab8d0   ubuntu    "/bin/bash"   35 seconds ago   Up 2 minutes              dynia_cedynia
```

```console
$ docker start dynia_cedynia
dynia_cedynia
$ docker start ogorek_bonzurek
ogorek_bonzurek
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS          PORTS     NAMES
cbcdf3bbf762   fedora    "/bin/bash"   15 seconds ago   Up 7 seconds              ogorek_bonzurek
ef1d776ab8d0   ubuntu    "/bin/bash"   45 seconds ago   Up 11 seconds             dynia_cedynia
```

```console
$ docker stop dynia_cedynia ogorek_bonzurek
dynia_cedynia
ogorek_bonzurek
$ docker start -i dynia_cedynia
^Ccontext canceled
$ docker start -i ogorek_bonzurek
[root@cbcdf3bbf762 /]#
```

* Creating container with interactive mode and pseudo-TTY allocated and volume mapping

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container create -i -t --name wazka_apaszka -v ./volume:/home/katheroine  debian
c08136aaeebd2d8f8973288132bda3d71b1aaa631251dc972d45f4205c32b5eb
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS          PORTS     NAMES
c08136aaeebd   debian    "bash"        5 seconds ago    Created                   wazka_apaszka
```

```console
$ mkdir volume
$ cd volume/
$ echo "Hello, Docker!" > hello.txt
```

```console
$ docker start -i wazka_apaszka
root@c08136aaeebd:/# ls
bin  boot  dev	etc  home  lib	lib64  media  mnt  opt	proc  root  run  sbin  srv  sys  tmp  usr  var
root@c08136aaeebd:/# cd home/katheroine/
root@c08136aaeebd:/home/katheroine# ls
hello.txt
root@c08136aaeebd:/home/katheroine# cat hello.txt
Hello, Docker!
```

## [Removing container](https://docs.docker.com/reference/cli/docker/container/rm)

```
docker container rm [OPTIONS] CONTAINER [CONTAINER...]
```

**Aliases**

```
docker container remove
```

```
docker rm
```

**Options**

```
  -f, --force     Force the removal of a running container (uses SIGKILL)
  -l, --link      Remove the specified link
  -v, --volumes   Remove anonymous volumes associated with the container
```

**Examples**

* Removing container by its name

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED        STATUS     PORTS     NAMES
1dca089c649a   debian    "bash"        44 hours ago   Created              gniotek_maskotek
c7619a41a1d5   fedora    "/bin/bash"   44 hours ago   Created              kwiatek_wariatek
81bcca685498   ubuntu    "/bin/bash"   45 hours ago   Created              kubek_belzebubek
```

```console
$ docker container rm kwiatek_wariatek
kwiatek_wariatek
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED        STATUS     PORTS     NAMES
1dca089c649a   debian    "bash"        44 hours ago   Created              gniotek_maskotek
81bcca685498   ubuntu    "/bin/bash"   45 hours ago   Created              kubek_belzebubek
```

* Removing container by its id

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED        STATUS     PORTS     NAMES
1dca089c649a   debian    "bash"        44 hours ago   Created              gniotek_maskotek
c7619a41a1d5   fedora    "/bin/bash"   44 hours ago   Created              kwiatek_wariatek
81bcca685498   ubuntu    "/bin/bash"   45 hours ago   Created              kubek_belzebubek
```

```console
$ docker container rm c7619a41a1d5
kwiatek_wariatek
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED        STATUS     PORTS     NAMES
1dca089c649a   debian    "bash"                   44 hours ago   Created              gniotek_maskotek
81bcca685498   ubuntu    "/bin/bash"              45 hours ago   Created              kubek_belzebubek
```

* An attempt of removing running container

When a container is running, it cannot be simply deleted. In such case, the option `-f` is needed to be used.

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS         PORTS     NAMES
c7619a41a1d5   fedora    "/bin/bash"   11 minutes ago   Up 2 minutes             kwiatek_wariatek
```

```console
$ docker container rm c7619a41a1d5
Error response from daemon: cannot remove container "/kwiatek_wariatek": container is running: stop the container before removing or force remove
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS         PORTS     NAMES
c7619a41a1d5   fedora    "/bin/bash"   11 minutes ago   Up 2 minutes             kwiatek_wariatek
```

* Force removing running container

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS         PORTS     NAMES
c7619a41a1d5   fedora    "/bin/bash"   11 minutes ago   Up 2 minutes             kwiatek_wariatek
```

```console
$ docker container rm -f c7619a41a1d5
c7619a41a1d5
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

## [Removing stopped containers](https://docs.docker.com/reference/cli/docker/container/prune)

```
docker container prune [OPTIONS]
```

**Options**

```
      --filter filter   Provide filter values (e.g. "until=<timestamp>")
  -f, --force           Do not prompt for confirmation
```

**Examples**

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED        STATUS                      PORTS     NAMES
1dca089c649a   debian    "bash"        46 hours ago   Created                               gniotek_maskotek
81bcca685498   ubuntu    "/bin/bash"   47 hours ago   Created                               kubek_belzebubek
c08136aaeebd   debian    "bash"        7 days ago     Exited (127) 6 days ago               wazka_apaszka
cbcdf3bbf762   fedora    "/bin/bash"   7 days ago     Exited (137) 46 hours ago             ogorek_bonzurek
ef1d776ab8d0   ubuntu    "/bin/bash"   7 days ago     Exited (137) 46 hours ago             dynia_cedynia
7f28aa0afc11   ubuntu    "/bin/bash"   7 days ago     Exited (0) 47 hours ago               panda_wanda
```

```console
$ docker container prune
WARNING! This will remove all stopped containers.
Are you sure you want to continue? [y/N] y
Deleted Containers:
1dca089c649a0c3da312797644d50a3b35b9b5646c33d0bcff1dc4b57423728d
81bcca685498013d48abb347a96bc99c6e9492166b38c3df592f0d130b3ddd7a
c08136aaeebd2d8f8973288132bda3d71b1aaa631251dc972d45f4205c32b5eb
cbcdf3bbf762e8cbc6e288b67ed8182efbda0dd86fc092f176a19006b5aeba35
ef1d776ab8d0d85ce922b962f275612b68d550026d72ed4165066919f6fe0761
7f28aa0afc113e6571a7fe1301a27c12e070314f58c2a8ff3afbd0004c95feb6

Total reclaimed space: 59B
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

## [Starting containers](https://docs.docker.com/reference/cli/docker/container/start)

```
docker container start [OPTIONS] CONTAINER [CONTAINER...]
```

**Aliases**

```
docker start
```

**Options**

```
  -a, --attach               Attach STDOUT/STDERR and forward signals
      --detach-keys string   Override the key sequence for detaching a container
  -i, --interactive          Attach container's STDIN
```

**Examples**

* Starting a container by its name

```console
$ docker container create --name maskotka_trzpiotka fedora
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS    PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   5 minutes ago   Created             trzpiotka_maskotka
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container start maskotka_trzpiotka
maskotka_trzpiotka
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS                      PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   6 minutes ago    Exited (0) 10 seconds ago             maskotka_trzpiotka
```

* Starting a container by its ID

```console
$ docker container create --name maskotka_trzpiotka fedora
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS    PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   5 minutes ago   Created             trzpiotka_maskotka
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container start 5685725054bf
5685725054bf
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS                      PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   6 minutes ago    Exited (0) 10 seconds ago             maskotka_trzpiotka
```

* Starting a container without STDOUR/STDERR attached

```console
$ docker container create -it --name komunikacja_abstrakcja debian sh -c "echo 'This is the message from STDOUT.'"
b16b662e1e0abb62a0c6bb694eeacd6a9ce17c744e77fbdc4781120d4d0e9b37
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND                  CREATED          STATUS    PORTS     NAMES
b16b662e1e0a   debian    "sh -c 'echo 'This i…"   13 seconds ago   Created             komunikacja_abstrakcja
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container start komunikacja_abstrakcja
komunikacja_abstrakcja
```

* Starting a container with STDOUR/STDERR attached

```console
$ docker container create -it --name komunikacja_abstrakcja debian sh -c "echo 'This is the message from STDOUT.'"
b16b662e1e0abb62a0c6bb694eeacd6a9ce17c744e77fbdc4781120d4d0e9b37
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND                  CREATED          STATUS    PORTS     NAMES
b16b662e1e0a   debian    "sh -c 'echo 'This i…"   13 seconds ago   Created             komunikacja_abstrakcja
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container start -a komunikacja_abstrakcja
This is the message from STDOUT.
```

* Starting noninteractively a container without interactive mode

```console
$ docker container create --name maskotka_trzpiotka fedora
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS    PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   5 minutes ago   Created             trzpiotka_maskotka
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

When a container has been created without an interactive mode, after `docker start` it will do its job and exit. It won't be listed on the `docker ps` output but the evidence it has been run will be visible on the `docker ps -a` list.

```console
$ docker container start maskotka_trzpiotka
maskotka_trzpiotka
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS                      PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   6 minutes ago    Exited (0) 10 seconds ago             maskotka_trzpiotka
```

* Starting interactively a container without interactive mode

```console
$ docker container create --name maskotka_trzpiotka fedora
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS    PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   5 minutes ago   Created             trzpiotka_maskotka
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

When a container has been created without an interactive mode, even after `docker start -i` it will do its job and exit. As in the previous case, it won't be listed on the `docker ps` output but the evidence it has been run will be visible on the `docker ps -a` list.

```console
$ docker container start -i maskotka_trzpiotka
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED          STATUS                      PORTS     NAMES
5685725054bf   fedora    "/bin/bash"   6 minutes ago    Exited (0) 10 seconds ago             maskotka_trzpiotka
```

* Starting noninteractively a container with interactive mode

```console
$ docker container create -i --name spinacz_wyginacz debian
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED         STATUS    PORTS     NAMES
66688bcd5773   debian    "bash"    5 minutes ago   Created             spinacz_wyginacz
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

When a container has been created with an interactive mode, after `docker start` it will do its job and still be running but the control will leave the container context and will return to the host console. The container will be listed on the `docker ps` output.

```console
$ docker container start spinacz_wyginacz
spinacz_wyginacz
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED         STATUS          PORTS     NAMES
66688bcd5773   debian    "bash"    6 minutes ago   Up 10 seconds             spinacz_wyginacz
```

* Starting interactively a container with interactive mode

```console
$ docker container create -i --name spinacz_wyginacz debian
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED         STATUS    PORTS     NAMES
66688bcd5773   debian    "bash"    5 minutes ago   Created             spinacz_wyginacz
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

When a container has been created with an interactive mode, after `docker start -i` it will do its job and still be running without leaving the container context until user hits `[Ctrl]+[C]`. The container will be listed on the `docker ps` output untill hitting `[Ctrl]+[C]` conbination. `[Ctrl]+[C]` pressed in the container context stops the container.

```console
$ docker container start -i spinacz_wyginacz

```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED         STATUS          PORTS     NAMES
66688bcd5773   debian    "bash"    6 minutes ago   Up 10 seconds             spinacz_wyginacz
```

* Starting interactively a container with interactive mode and pseudo-TTY allocated

```console
$ docker container create -i -t --name agrafka_ustawka ubuntu
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS    PORTS     NAMES
fbc250c131c0   ubuntu    "/bin/bash"   5 minutes ago   Created             agrafka_ustawka
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

When a container has been created with an interactive mode and pseudo-TTY allocated, after `docker start -i` it will do its job and still be running without leaving the container context with TTY waiting for the user commands, until exit the TTY. The container will be listed on the `docker ps` output untill TTY stop.

```console
$ docker container start -i agrafka_ustawka
root@fbc250c131c0:/#
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND       CREATED         STATUS          PORTS     NAMES
fbc250c131c0   ubuntu    "/bin/bash"   6 minutes ago   Up 10 seconds             agrafka_ustawka
```

* Difference between `-a` and `-i` options

```console
$ docker container create -it --name starterek_leserek ubuntu sh -c 'echo "Container started. Type something and press Enter:" && read input && echo "You typed: $input"'
deb15a78ef7aa432ec928a075000e0fc9ea580f51043ea61cb8491187221b93b
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND                  CREATED          STATUS    PORTS     NAMES
deb15a78ef7a   ubuntu    "sh -c 'echo 'Contai…"   5 minutes ago    Created             starterek_leserek
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

Using `-a` option will allow to see the output of the container redirected to STDOUT of the host but will not allow to send the user input from the host STDIN to the container. Hitting `[Ctrl]+[C]` will cause exit the container context but the system of the container will be still waiting for the user input.

```console
$ docker container start -a starterek_leserek
Container started. Type something and press Enter:
Hello
^Ccontext canceled
```

```console
docker ps
CONTAINER ID   IMAGE     COMMAND                  CREATED         STATUS         PORTS     NAMES
deb15a78ef7a   ubuntu    "sh -c 'echo 'Contai…"   6 minutes ago   Up 5 minutes             starterek_leserek
$ docker container stop starterek_leserek
starterek_leserek
```

Using the `-i` option will allow to see the output of the container redirected to STDOUT of the host and will allow to send the user input from the host STDIN to the container. The system of the container will be able to finish its job.

```console
$ docker container start -i starterek_leserek
Container started. Type something and press Enter:
Hello
You typed: Hello
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

## [Stopping containers](https://docs.docker.com/reference/cli/docker/container/stop)

```
docker container stop [OPTIONS] CONTAINER [CONTAINER...]
```

**Aliases**

```
docker stop
```

**Options**

```
  -s, --signal string   Signal to send to the container
  -t, --timeout int     Seconds to wait before killing the container
```

**Examples**

* Stopping a container by its name

```console
$ docker ps
CONTAINER ID   IMAGE                             COMMAND                  CREATED        STATUS         PORTS                                     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"   10 hours ago   Up 4 seconds   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp   ekierka_szpanerka
```

```console
$ docker container stop ekierka_szpanerka
ekierka_szpanerka
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE                             COMMAND                   CREATED        STATUS                      PORTS     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"    10 hours ago   Exited (0) 25 seconds ago             ekierka_szpanerka
```

* Stopping a container by its ID

```console
$ docker ps
CONTAINER ID   IMAGE                             COMMAND                  CREATED        STATUS         PORTS                                     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"   10 hours ago   Up 4 seconds   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp   ekierka_szpanerka
```

```console
$ docker container stop e3b2a7d02680
e3b2a7d02680
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE                             COMMAND                   CREATED        STATUS                      PORTS     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"    10 hours ago   Exited (0) 25 seconds ago             ekierka_szpanerka
```

* Stopping container by chosen signal

```console
$ docker ps
CONTAINER ID   IMAGE                             COMMAND                  CREATED        STATUS         PORTS                                     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"   10 hours ago   Up 4 seconds   0.0.0.0:8080->80/tcp, [::]:8080->80/tcp   ekierka_szpanerka
```

By default, the signal sending to the system of the container is a `TERM` singnal given by its number `7` or name `SIGTERM`, which gives the `0` code of the status displayed by `docker ps -a`. After choosing `KILL` signal given by its number `9` or name `SIGKILL`, thecontainer system stops immediately, and the code `137` of the status displayed by `docker ps -a` is shown.

```console
$ docker container stop -s 9 ekierka_szpanerka
ekierka_szpanerka
```

```console
$ docker ps
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
$ docker ps -a
CONTAINER ID   IMAGE                             COMMAND                   CREATED        STATUS                       PORTS     NAMES
e3b2a7d02680   docker/welcome-to-docker:latest   "/docker-entrypoint.…"    10 hours ago   Exited (137) 25 seconds ago            ekierka_szpanerka
```

## [Running (creating & starting) the container](https://docs.docker.com/reference/cli/docker/container/run)

```
docker container run [OPTIONS] IMAGE [COMMAND] [ARG...]
```

**Aliases**

```
docker run
```

**Options**

```
      --add-host list                    Add a custom host-to-IP mapping (host:ip)
      --annotation map                   Add an annotation to the container (passed through to the OCI runtime) (default map[])
  -a, --attach list                      Attach to STDIN, STDOUT or STDERR
      --blkio-weight uint16              Block IO (relative weight), between 10 and 1000, or 0 to disable (default 0)
      --blkio-weight-device list         Block IO weight (relative device weight) (default [])
      --cap-add list                     Add Linux capabilities
      --cap-drop list                    Drop Linux capabilities
      --cgroup-parent string             Optional parent cgroup for the container
      --cgroupns string                  Cgroup namespace to use (host|private)
                                         'host':    Run the container in the Docker host's cgroup namespace
                                         'private': Run the container in its own private cgroup namespace
                                         '':        Use the cgroup namespace as configured by the
                                                    default-cgroupns-mode option on the daemon (default)
      --cidfile string                   Write the container ID to the file
      --cpu-period int                   Limit CPU CFS (Completely Fair Scheduler) period
      --cpu-quota int                    Limit CPU CFS (Completely Fair Scheduler) quota
      --cpu-rt-period int                Limit CPU real-time period in microseconds
      --cpu-rt-runtime int               Limit CPU real-time runtime in microseconds
  -c, --cpu-shares int                   CPU shares (relative weight)
      --cpus decimal                     Number of CPUs
      --cpuset-cpus string               CPUs in which to allow execution (0-3, 0,1)
      --cpuset-mems string               MEMs in which to allow execution (0-3, 0,1)
  -d, --detach                           Run container in background and print container ID
      --detach-keys string               Override the key sequence for detaching a container
      --device list                      Add a host device to the container
      --device-cgroup-rule list          Add a rule to the cgroup allowed devices list
      --device-read-bps list             Limit read rate (bytes per second) from a device (default [])
      --device-read-iops list            Limit read rate (IO per second) from a device (default [])
      --device-write-bps list            Limit write rate (bytes per second) to a device (default [])
      --device-write-iops list           Limit write rate (IO per second) to a device (default [])
      --disable-content-trust            Skip image verification (default true)
      --dns list                         Set custom DNS servers
      --dns-option list                  Set DNS options
      --dns-search list                  Set custom DNS search domains
      --domainname string                Container NIS domain name
      --entrypoint string                Overwrite the default ENTRYPOINT of the image
  -e, --env list                         Set environment variables
      --env-file list                    Read in a file of environment variables
      --expose list                      Expose a port or a range of ports
      --gpus gpu-request                 GPU devices to add to the container ('all' to pass all GPUs)
      --group-add list                   Add additional groups to join
      --health-cmd string                Command to run to check health
      --health-interval duration         Time between running the check (ms|s|m|h) (default 0s)
      --health-retries int               Consecutive failures needed to report unhealthy
      --health-start-interval duration   Time between running the check during the start period (ms|s|m|h) (default 0s)
      --health-start-period duration     Start period for the container to initialize before starting health-retries countdown (ms|s|m|h) (default 0s)
      --health-timeout duration          Maximum time to allow one check to run (ms|s|m|h) (default 0s)
      --help                             Print usage
  -h, --hostname string                  Container host name
      --init                             Run an init inside the container that forwards signals and reaps processes
  -i, --interactive                      Keep STDIN open even if not attached
      --ip string                        IPv4 address (e.g., 172.30.100.104)
      --ip6 string                       IPv6 address (e.g., 2001:db8::33)
      --ipc string                       IPC mode to use
      --isolation string                 Container isolation technology
      --kernel-memory bytes              Kernel memory limit
  -l, --label list                       Set meta data on a container
      --label-file list                  Read in a line delimited file of labels
      --link list                        Add link to another container
      --link-local-ip list               Container IPv4/IPv6 link-local addresses
      --log-driver string                Logging driver for the container
      --log-opt list                     Log driver options
      --mac-address string               Container MAC address (e.g., 92:d0:c6:0a:29:33)
  -m, --memory bytes                     Memory limit
      --memory-reservation bytes         Memory soft limit
      --memory-swap bytes                Swap limit equal to memory plus swap: '-1' to enable unlimited swap
      --memory-swappiness int            Tune container memory swappiness (0 to 100) (default -1)
      --mount mount                      Attach a filesystem mount to the container
      --name string                      Assign a name to the container
      --network network                  Connect a container to a network
      --network-alias list               Add network-scoped alias for the container
      --no-healthcheck                   Disable any container-specified HEALTHCHECK
      --oom-kill-disable                 Disable OOM Killer
      --oom-score-adj int                Tune host's OOM preferences (-1000 to 1000)
      --pid string                       PID namespace to use
      --pids-limit int                   Tune container pids limit (set -1 for unlimited)
      --platform string                  Set platform if server is multi-platform capable
      --privileged                       Give extended privileges to this container
  -p, --publish list                     Publish a container's port(s) to the host
  -P, --publish-all                      Publish all exposed ports to random ports
      --pull string                      Pull image before running ("always", "missing", "never") (default "missing")
  -q, --quiet                            Suppress the pull output
      --read-only                        Mount the container's root filesystem as read only
      --restart string                   Restart policy to apply when a container exits (default "no")
      --rm                               Automatically remove the container and its associated anonymous volumes when it exits
      --runtime string                   Runtime to use for this container
      --security-opt list                Security Options
      --shm-size bytes                   Size of /dev/shm
      --sig-proxy                        Proxy received signals to the process (default true)
      --stop-signal string               Signal to stop the container
      --stop-timeout int                 Timeout (in seconds) to stop a container
      --storage-opt list                 Storage driver options for the container
      --sysctl map                       Sysctl options (default map[])
      --tmpfs list                       Mount a tmpfs directory
  -t, --tty                              Allocate a pseudo-TTY
      --ulimit ulimit                    Ulimit options (default [])
      --use-api-socket                   Bind mount Docker API socket and required auth
  -u, --user string                      Username or UID (format: <name|uid>[:<group|gid>])
      --userns string                    User namespace to use
      --uts string                       UTS namespace to use
  -v, --volume list                      Bind mount a volume
      --volume-driver string             Optional volume driver for the container
      --volumes-from list                Mount volumes from the specified container(s)
  -w, --workdir string                   Working directory inside the container
```

***The most important `docker container run` options and its availability in `docker container create` and `docker container start` commands***

| Option               | docker run | docker create | docker start |
|----------------------|------------|---------------|--------------|
| `-i` (interactive)   | Yes        | Yes           | Yes          |
| `--name`             | Yes        | Yes           | No           |
| `-d` (detach)        | Yes        | Yes           | No           |
| `-t` (tty)           | Yes        | Yes           | No           |
| `-p` (publish ports) | Yes        | Yes           | No           |
| `-v` (volume)        | Yes        | Yes           | No           |
| `-e` (env)           | Yes        | Yes           | No           |
| `--entrypoint`       | Yes        | Yes           | No           |
| `--workdir`          | Yes        | Yes           | No           |
| `--restart`          | Yes        | No            | No           |
| `--rm`               | Yes        | No            | No           |

**Examples**

* Running the container with image not downloaded yet

```console
$ docker images
REPOSITORY                 TAG       IMAGE ID       CREATED       SIZE
debian                     latest    047bd8d81940   3 weeks ago   120MB
fedora                     latest    f464a67b6b66   4 weeks ago   164MB
ubuntu                     latest    e0f16e6366fe   4 weeks ago   78.1MB
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container run archlinux
Unable to find image 'archlinux:latest' locally
latest: Pulling from library/archlinux
6f6dbfeb25e4: Pull complete
235e4b51ca8e: Pull complete
Digest: sha256:97c56e9c792dc50df96c77187255a752f479698c9beb4aa9caeb9fe4639a7590
Status: Downloaded newer image for archlinux:latest
```

```console
$ docker images
REPOSITORY                 TAG       IMAGE ID       CREATED       SIZE
archlinux                  latest    72d908c4dc4a   8 days ago    490MB
debian                     latest    047bd8d81940   3 weeks ago   120MB
fedora                     latest    f464a67b6b66   4 weeks ago   164MB
ubuntu                     latest    e0f16e6366fe   4 weeks ago   78.1MB
docker ps -a
CONTAINER ID   IMAGE     COMMAND           CREATED          STATUS                      PORTS     NAMES
5cd481d89692   archlinux "/usr/bin/bash"   10 minutes ago   Exited (0) 10 minutes ago             sweet_bhaskara
```

* Running the container with image already downloaded to the host

```console
$ docker images
REPOSITORY                 TAG       IMAGE ID       CREATED       SIZE
debian                     latest    047bd8d81940   3 weeks ago   120MB
fedora                     latest    f464a67b6b66   4 weeks ago   164MB
ubuntu                     latest    e0f16e6366fe   4 weeks ago   78.1MB
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container run ubuntu
```

```console
$ docker images
REPOSITORY                 TAG       IMAGE ID       CREATED       SIZE
debian                     latest    047bd8d81940   3 weeks ago   120MB
fedora                     latest    f464a67b6b66   4 weeks ago   164MB
ubuntu                     latest    e0f16e6366fe   4 weeks ago   78.1MB
docker ps -a
CONTAINER ID   IMAGE     COMMAND           CREATED          STATUS                      PORTS     NAMES
af23329b8f75   ubuntu    "/bin/bash"       55 seconds ago   Exited (0) 50 seconds ago             priceless_bassi
```

* Running container with defined name

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
```

```console
$ docker container run --name lisek_zdzisiek debian
```

```console
$ docker ps -a
CONTAINER ID   IMAGE     COMMAND   CREATED         STATU                      PORTS     NAMES
d3d1ea110dbb   debian    "bash"    8 seconds ago   Exited (0) 6 seconds ago             lisek_zdzisiek
```
