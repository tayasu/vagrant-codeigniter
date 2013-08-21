#
# Cookbook Name:: postfix
# Recipe:: default
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

%w{postfix}.each do |pkg|
  package pkg do
    action :install
  end
end

template "/etc/postfix/main.cf" do
    source "main.cf.erb"
    owner "root"
    group "root"
    mode 0644
end

template "/etc/postfix/virtual" do                                                         
    source "virtual.erb"                                                                   
    owner "root"
    group "root"
    mode 0644
end

template "/etc/postfix/virtual_alias" do
    source "virtual_alias.erb"     
    owner "root"
    group "root"
    mode 0644
end

group "vmail" do 
  action :create
end

user "vmail" do
  shell "/sbin/nologin"
  home "/home/vmail"
  password nil
  gid "vmail"
  supports :manage_home => true
  action :create
end

service "sendmail" do
  supports :status => false, :restart => false, :reload => false
  action [ :disable, :stop ]
end

service "postfix" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end

execute "mta setting" do
  command "alternatives --set mta /usr/sbin/sendmail.postfix"
end


