#
# Cookbook Name:: php53
# Recipe:: default
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

#%w{ php53.x86_64 php53-devel.x86_64 php53-mysql.x86_64 php53-cli.x86_64 php53-common.x86_64 php53-pdo.x86_64 }.each do |pkg|
%w{ php53 php53-devel php53-mysql php53-cli php53-common php53-pdo }.each do |pkg|
  package pkg do
    action :install
  end
end

template "/etc/php.ini" do
  source "php.ini.erb"
  owner "root"
  group "root"
  mode "0644"
end



