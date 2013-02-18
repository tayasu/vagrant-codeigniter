# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant::Config.run do |config|
  config.vm.box = 'centos55'
  config.vm.box_url = 'https://dl.dropbox.com/u/148070/CentOS-5.5-x86_64.box'
  config.vm.network :hostonly, '33.33.33.99'
  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = 'cookbooks'
    chef.roles_path = "roles"
    chef.add_role "vagrant-codeigniter"
    chef.json.merge!({
        :mysql => {
          :database_name => 'vc',
          :server_root_password => ''
        },
        :languages => {
          :perl => {
            :version => '5.8.8'
          }
        }
      })
  end
end
