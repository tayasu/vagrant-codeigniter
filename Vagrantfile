# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = 'rw_centos_57'
  config.vm.box_url = 'http://hglab.realworld.jp/boxes/CentOS-5.7-i386.box'
  config.vm.network :hostonly, '33.33.33.99'
  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = 'cookbooks'
    chef.roles_path = "roles"
    chef.add_role "vagrant-codeigniter"
    chef.json.merge!({
        :mysql55 => {
          :version => '5.5.33-1.el5.remi',
        },
        :mysql => {
          :database_name => 'codeigniter',
          :server_root_password => ''
        },
        :apache => {
          :package => 'httpd',
        },
        :languages => {
          :perl => {
            :version => '5.8.8'
          }
        }
      })
  end
end
