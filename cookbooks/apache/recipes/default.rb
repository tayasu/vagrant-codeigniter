#
# Cookbook Name:: apache
# Recipe:: default
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

%w{httpd httpd-devel apr-devel apr-util-devel }.each do |pkg|
  package pkg do
    action :install
  end
end

execute "welcome.conf.back" do
  command "mv /etc/httpd/conf.d/welcome.conf /etc/httpd/conf.d/welcome.conf.back"
  only_if {
    File.exists?("/etc/httpd/conf.d/welcome.conf")
  }
end

=begin
template "/etc/httpd/conf.d/000-vhost.conf" do
    source "000-vhost.conf.erb"
    owner "root"
    group "root"
    mode 0644
end

template "/etc/httpd/conf/httpd.conf" do
    source "httpd.conf.erb"
    owner "root"
    group "root"
    mode 0644
end
=end

service "httpd" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end

