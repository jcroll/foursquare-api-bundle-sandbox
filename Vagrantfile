# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.ssh.forward_agent = true
  config.ssh.username = "vagrant"
  config.ssh.password = "vagrant"

  config.vm.provider :virtualbox do |v|
    cpus = `sysctl -n hw.ncpu`.to_i
    mem  = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 4

    v.customize ['modifyvm', :id, '--cpuexecutioncap', '75']
    v.customize ['modifyvm', :id, '--cpus', cpus]
    v.customize ['modifyvm', :id, '--memory', mem]
    v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    v.customize ["modifyvm", :id, "--ioapic", "on"]
  end

  config.vm.network :private_network, ip: "192.168.33.35"

  config.vm.synced_folder ".", "/var/www/foursquare-api-bundle-sandbox",
      :nfs => true,
      :mount_options => ['actimeo=2']

  # Ansible provisioner.
  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "provisioning/site.yml"
    ansible.inventory_path = "provisioning/inventory"
    ansible.limit = "vagrant.dev.foursquare-api-bundle-sandbox.com"
    ansible.verbose = 'v'
    #ansible.tags = ["foursquare-api-bundle-sandbox"]
  end

end