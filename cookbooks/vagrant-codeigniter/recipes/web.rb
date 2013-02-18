include_recipe "apache2"
include_recipe "apache2::mod_php5"

apache_module "rewrite"

template "vagrant-codeigniter" do
  path "#{node[:apache][:dir]}/sites-available/vagrant-codeigniter"
  source "vagrant-codeigniter.erb"
  owner "apache"
  group "apache"
  mode "0644"
end

execute "site-enabled" do
  command "a2ensite vagrant-codeigniter"
  notifies :restart, resources(:service => "apache2")
end

directory "/var/log/vagrant-codeigniter" do
  owner "apache"
  group "apache"
  mode "0755"
  action :create
end

service "iptables" do
  action :stop
end
