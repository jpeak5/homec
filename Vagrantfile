# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "debian/contrib-stretch64"
  config.ssh.insert_key = false
  config.vm.network "private_network", ip: "192.168.100.100"
   config.vm.network "forwarded_port", guest: 5000, host: 8000
  config.vm.synced_folder "app/", "/mnt/app"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "build.yml"
    ansible.extra_vars = {
      ansible_python_interpreter:"/usr/bin/python3"
    }
  end
end
