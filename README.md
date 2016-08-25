# Jcroll Foursquare Api Bundle Sandbox

## Installation

1. Install Vagrant
2. Install Ansible
3. Install Ansible dependencies:

```
$ sudo ansible-galaxy install -r requirements.yml --force
```

4. Set your hosts file

```
$ sudo printf "\n192.168.33.35  foursquare-api-bundle-sandbox.l" >> /etc/hosts
```

5. Bring up Vagrant

```
$ vagrant up
```