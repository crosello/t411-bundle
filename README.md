#T411-bundle

Bundle for T411 API Client 
[https://github.com/crosello/t411](https://github.com/crosello/t411)

## Installation

`composer require crosello/t411-bundle`

## Register

Register the bundle in your kernel

```
public function registerBundles()
    {
        $bundles = array(
            // ...
            new Rosello\T411Bundle\T411Bundle(),
        );
```

## Configuration

Configure bundle in your `app.yml`

```
t411:
    limit: 10            # Maximum number of torrents that repository will return
    token:
        storage: session # Where store token (session, cookie, false)
        name: t411_token # Name of session|cookie
        expire: 40       # Lifetime cookie (for cookie only)
```

Then, add your user / password in your `parameters.yml`

```
parameters:
    t411_user: user
    t411_password: password
```

## Usage

### Search Torrents

Use service `t411.repository.torrents` to search torrents

```
$this->get('t411.repository.torrents')->search('Ubuntu');
```