# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "parallels/ubuntu-14.04"
  config.vm.host_name = "sparrow.localhost"
  config.vm.network "private_network", ip: "192.168.66.69"

  config.vm.synced_folder ".", "/var/www/sparrow", type: "nfs"

  config.vm.synced_folder "../../phpqatools", "/var/www/php", type: "nfs"

  config.vm.provider "parallels" do |v|
  end

end
