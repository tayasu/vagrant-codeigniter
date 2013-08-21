#
# Cookbook Name:: mysql55
# Recipe:: default
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

%w{mysql-server mysql-devel}.each do |pkg|
  package pkg do
    action :install
    version node['mysql55']['version']
  end
end

service "mysqld" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end

template "/etc/my.cnf" do
  source "my.cnf.erb"
  owner "root"
  group "root"
  mode "0644"
  notifies :restart, resources(:service => "mysqld"), :immediately
end
