# Dockerfile format & syntax

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

## Format

Here is the format of the Dockerfile:

```dockerfile
# Comment
INSTRUCTION arguments
```

*The instruction is not case-sensitive.* However, convention is for them to be UPPERCASE to distinguish them from arguments more easily.

Docker runs instructions in a Dockerfile in order. *A Dockerfile must begin with a [`FROM`](https://docs.docker.com/reference/dockerfile/#from) instruction.* This may be after parser directives, comments, and globally scoped `ARG`s. The `FROM` instruction specifies the **base image** from which you are building. `FROM` may only be preceded by one or more [`ARG`](https://docs.docker.com/reference/dockerfile/#arg) instructions, which declare arguments that are used in `FROM` lines in the Dockerfile.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#format)

## Parser directives

**Parser directives** are optional, and affect the way in which subsequent lines in a Dockerfile are handled. Parser directives don't add layers to the build, and don't show up as build steps. Parser directives are written as a special type of comment in the form `# directive=value`. A single directive may only be used once.

The following parser directives are supported:

* `syntax`
* `escape`
* `check` (since Dockerfile v1.8.0)

Once a comment, empty line or builder instruction has been processed, BuildKit no longer looks for parser directives. Instead it treats anything formatted as a parser directive as a comment and doesn't attempt to validate if it might be a parser directive. Therefore, *all parser directives must be at the top of a Dockerfile*.

*Parser directive keys, such as `syntax` or `check`, aren't case-sensitive*, but they're lowercase by convention. *Values for a directive are case-sensitive* and must be written in the appropriate case for the directive. For example, `#check=skip=jsonargsrecommended` is invalid because the `check` name must use Pascal case, not lowercase. It's also conventional to include a blank line following any parser directives. Line continuation characters aren't supported in parser directives.

Due to these rules, the following examples are all invalid:

* Invalid due to line continuation:

```dockerfile
# direc \
tive=value
```

* Invalid due to appearing twice:

```dockerfile
# directive=value1
# directive=value2

FROM ImageName
```

* Treated as a comment because it appears after a builder instruction:

```dockerfile
FROM ImageName
# directive=value
```

* Treated as a comment because it appears after a comment that isn't a parser directive:

```dockerfile
# About my dockerfile
# directive=value
FROM ImageName
```

* The following `unknowndirective` is treated as a comment because it isn't recognized. The known syntax directive is treated as a comment because it appears after a comment that isn't a parser directive.

```dockerfile
# unknowndirective=value
# syntax=value
```

* Non line-breaking whitespace is permitted in a parser directive. Hence, the following lines are all treated identically:

```dockerfile
#directive=value
# directive =value
#	directive= value
# directive = value
#	  dIrEcTiVe=value
```

### `syntax`

Use the `syntax` parser directive to declare the Dockerfile syntax version to use for the build. If unspecified, BuildKit uses a bundled version of the Dockerfile frontend. Declaring a syntax version lets you automatically use the latest Dockerfile version without having to upgrade BuildKit or Docker Engine, or even use a custom Dockerfile implementation.

Most users will want to set this parser directive to `docker/dockerfile:1`, which causes BuildKit to pull the latest stable version of the Dockerfile syntax before the build.

```dockerfile
# syntax=docker/dockerfile:1
```

### `escape`

```dockerfile
# escape=\
```

Or

```dockerfile
# escape=`
```

The `escape` directive sets the character used to escape characters in a Dockerfile. If not specified, the default escape character is `\`.

*The escape character is used both to escape characters in a line, and to escape a newline.* This allows a Dockerfile instruction to span multiple lines. Note that regardless of whether the escape parser directive is included in a Dockerfile, *escaping is not performed in a `RUN` command, except at the end of a line*.

Setting the escape character to `` ` `` is especially useful on Windows, where `\` is the directory path separator. `` ` `` is consistent with Windows PowerShell.

Consider the following example which would fail in a non-obvious way on Windows. The second `\` at the end of the second line would be interpreted as an escape for the newline, instead of a target of the escape from the first `\`. Similarly, the `\` at the end of the third line would, assuming it was actually handled as an instruction, cause it be treated as a line continuation. The result of this Dockerfile is that second and third lines are considered a single instruction:

```dockerfile
FROM microsoft/nanoserver
COPY testfile.txt c:\\
RUN dir c:\
```

Results in:

```
PS E:\myproject> docker build -t cmd .

Sending build context to Docker daemon 3.072 kB
Step 1/2 : FROM microsoft/nanoserver
 ---> 22738ff49c6d
Step 2/2 : COPY testfile.txt c:\RUN dir c:
GetFileAttributesEx c:RUN: The system cannot find the file specified.
PS E:\myproject>
```

One solution to the above would be to use `/` as the target of both the `COPY` instruction, and dir. However, this syntax is, at best, confusing as it is not natural for paths on Windows, and at worst, error prone as not all commands on Windows support `/` as the path separator.

By adding the escape parser directive, the following Dockerfile succeeds as expected with the use of natural platform semantics for file paths on Windows:

```dockerfile
# escape=`

FROM microsoft/nanoserver
COPY testfile.txt c:\
RUN dir c:\
```

Results in:

```
PS E:\myproject> docker build -t succeeds --no-cache=true .

Sending build context to Docker daemon 3.072 kB
Step 1/3 : FROM microsoft/nanoserver
 ---> 22738ff49c6d
Step 2/3 : COPY testfile.txt c:\
 ---> 96655de338de
Removing intermediate container 4db9acbb1682
Step 3/3 : RUN dir c:\
 ---> Running in a2c157f842f5
 Volume in drive C has no label.
 Volume Serial Number is 7E6D-E0F7

 Directory of c:\

10/05/2016  05:04 PM             1,894 License.txt
10/05/2016  02:22 PM    DIR          Program Files
10/05/2016  02:14 PM    DIR          Program Files (x86)
10/28/2016  11:18 AM                62 testfile.txt
10/28/2016  11:20 AM    DIR          Users
10/28/2016  11:20 AM    DIR          Windows
           2 File(s)          1,956 bytes
           4 Dir(s)  21,259,096,064 bytes free
 ---> 01c7f3bef04f
Removing intermediate container a2c157f842f5
Successfully built 01c7f3bef04f
PS E:\myproject>
```

### `check`

```
# check=skip=<checks|all>
```

```
# check=error=<boolean>
```

The check directive is used to configure how build checks are evaluated. By default, all checks are run, and failures are treated as warnings.

You can disable specific checks using `#check=skip=<check-name>`. To specify multiple checks to skip, separate them with a comma:

```dockerfile
# check=skip=JSONArgsRecommended,StageNameCasing
```

To disable all checks, use `#check=skip=all`.

By default, builds with failing build checks exit with a zero status code despite warnings. To make the build fail on warnings, set `#check=error=true`.

```dockerfile
# check=error=true
```

When using the `check` directive, with `error=true` option, it is recommended to pin the Dockerfile syntax to a specific version. Otherwise, your build may start to fail when new checks are added in the future versions.

To combine both the skip and error options, use a semi-colon to separate them:

```dockerfile
# check=skip=JSONArgsRecommended;error=true
```

Note that the checks available depend on the Dockerfile syntax version. To make sure you're getting the most up-to-date checks, use the syntax directive to specify the Dockerfile syntax version to the latest stable version.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#parser-directives)

## Environment replacement

**Environment variables** (declared with the `ENV` statement) can also be used in certain instructions as variables to be interpreted by the Dockerfile. Escapes are also handled for including variable-like syntax into a statement literally.

Environment variables are notated in the Dockerfile either with `$variable_name` or `${variable_name}`. They are treated equivalently and the brace syntax is typically used to address issues with variable names with no whitespace, like `${foo}_bar`.

The `${variable_name}` syntax also supports a few of the standard bash modifiers as specified below:

* `${variable:-word}` indicates that if variable is set then the result will be that value. If variable is not set then `word` will be the result.
* `${variable:+word}` indicates that if variable is set then `word` will be the result, otherwise the result is the empty string.

The following variable replacements are supported in a pre-release version of Dockerfile syntax, when using the `# syntax=docker/dockerfile-upstream:master` syntax directive in your
Dockerfile:

* `${variable#pattern}` removes the shortest match of pattern from variable, seeking from the start of the string.

```dockerfile
str=foobarbaz echo ${str#f*b} # arbaz
```

* `${variable##pattern}` removes the longest match of pattern from variable, seeking from the start of the string.

```dockerfile
str=foobarbaz echo ${str##f*b} # az
```

* `${variable%pattern}` removes the shortest match of pattern from variable, seeking backwards from the end of the string.

```dockerfile
string=foobarbaz echo ${string%b*} # foobar
```

* `${variable%%pattern}` removes the longest match of pattern from variable, seeking backwards from the end of the string.

```dockerfile
string=foobarbaz echo ${string%%b*} # foo
```

* `${variable/pattern/replacement}` replace the first occurrence of pattern in variable with replacement

```dockerfile
string=foobarbaz echo ${string/ba/fo} # fooforbaz
```

* `${variable//pattern/replacement}` replaces all occurrences of pattern in variable with replacement

```dockerfile
string=foobarbaz echo ${string//ba/fo} # fooforfoz
```

In all cases, `word` can be any string, including additional environment variables.

`pattern` is a glob pattern where `?` matches any single character and `*` any number of characters (including zero). To match literal `?` and `*`, use a backslash escape: `\?` and `\*`.

You can escape whole variable names by adding a `\` before the variable: `\$foo` or `\${foo}`, for example, will translate to `$foo` and `${foo}` literals respectively.

Example (parsed representation is displayed after the `#`):

```dockerfile
FROM busybox
ENV FOO=/bar
WORKDIR ${FOO} # WORKDIR /bar
ADD . $FOO # ADD . /bar
COPY \$FOO /quux # COPY $FOO /quux
```

Environment variables are supported by the following list of instructions in the Dockerfile:

* `ADD`
* `COPY`
* `ENV`
* `EXPOSE`
* `FROM`
* `LABEL`
* `STOPSIGNAL`
* `USER`
* `VOLUME`
* `WORKDIR`
* `ONBUILD` (when combined with one of the supported instructions above)

You can also use environment variables with `RUN`, `CMD`, and `ENTRYPOINT` instructions, but *in those cases the variable substitution is handled by the command shell, not the builder*. Note that *instructions using the exec form don't invoke a command shell automatically*.

Environment variable substitution use the same value for each variable throughout the entire instruction. *Changing the value of a variable only takes effect in subsequent instructions.* Consider the following example:

```dockerfile
ENV abc=hello
ENV abc=bye def=$abc
ENV ghi=$abc
```

The value of `def` becomes `hello`
The value of `ghi` becomes `bye`

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#environment-replacement)

## `.dockerignore` file

You can use `.dockerignore` file to exclude files and directories from the build context.

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#dockerignore-file)

## Shell and exec form

The `RUN`, `CMD`, and `ENTRYPOINT` instructions all have two possible forms:

* `INSTRUCTION ["executable","param1","param2"]` - exec form
* `INSTRUCTION command param1 param2` - shell form

The **exec form** makes it possible to avoid shell string munging, and to invoke commands using a specific command shell, or any other executable. It uses a JSON array syntax, where each element in the array is a command, flag, or argument.

The **shell form** is more relaxed, and emphasizes ease of use, flexibility, and readability. The *shell form* automatically uses a command shell, whereas the *exec form* does not.

### Exec form

The *exec form* is parsed as a JSON array, which means that *you must use double-quotes (`"`) around words, not single-quotes (`'`)*.

```dockerfile
ENTRYPOINT ["/bin/bash", "-c", "echo hello"]
```

The exec form is best used to specify an `ENTRYPOINT` instruction, combined with `CMD` for setting default arguments that can be overridden at runtime. For more information, see `ENTRYPOINT`.

***Variable substitution***

Using the *exec form* doesn't automatically invoke a command shell. This means that *normal shell processing, such as variable substitution, doesn't happen*. For example, `RUN [ "echo", "$HOME" ]` won't handle variable substitution for `$HOME`.

If you want shell processing then either use the *shell form* or execute a shell directly with the *exec form*, for example: `RUN [ "sh", "-c", "echo $HOME" ]`. When using the *exec form* and executing a shell directly, as in the case for the *shell form*, it's the shell that's doing the environment variable substitution, not the builder.

***Backslashes***

In *exec form*, you must escape backslashes. This is particularly relevant on Windows where the backslash is the path separator. The following line would otherwise be treated as *shell form* due to not being valid JSON, and fail in an unexpected way:

```dockerfile
RUN ["c:\windows\system32\tasklist.exe"]
```

The correct syntax for this example is:

```dockerfile
RUN ["c:\\windows\\system32\\tasklist.exe"]
```

### Shell form

Unlike the *exec form*, instructions using the *shell form* always use a command shell. The *shell form* doesn't use the JSON array format, instead it's a regular string. The *shell form* string lets you escape newlines using the escape character (backslash by default) to continue a single instruction onto the next line. This makes it easier to use with longer commands, because it lets you split them up into multiple lines. For example, consider these two lines:

```dockerfile
RUN source $HOME/.bashrc && \
echo $HOME
```

They're equivalent to the following line:

```dockerfile
RUN source $HOME/.bashrc && echo $HOME
```

You can also use heredocs with the shell form to break up supported commands.

```dockerfile
RUN <<EOF
source $HOME/.bashrc && \
echo $HOME
EOF
```

### Use a different shell

You can change the default shell using the SHELL command. For example:

```dockerfile
SHELL ["/bin/bash", "-c"]
RUN echo hello
```

-- [Docker Documentation](https://docs.docker.com/reference/dockerfile/#shell-and-exec-form)
