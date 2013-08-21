#
# Cookbook Name:: php53
# Recipe:: default
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

%w{ php53-gd }.each do |pkg|
  package pkg do
    action :install
  end
end
