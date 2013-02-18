name "vagrant-codeigniter"
description "vagrant-codeigniter roles"
run_list(
  "selinux::disabled",
  "yum::epel",
  "ntp",
  "postfix",
  "vagrant-codeigniter::db",
  "vagrant-codeigniter::web",
  "vagrant-codeigniter::php"
  )
