include_recipe "apache"

template "vagrant-codeigniter" do
  path "/etc/httpd/conf.d/vagrant-codeigniter.local.conf"
  source "vagrant-codeigniter.erb"
  owner "apache"
  group "apache"
  mode "0644"
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
