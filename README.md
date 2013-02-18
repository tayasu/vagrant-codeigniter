VagrantとCodeIgniter
======================

Vagrant環境の作成
------------------

### VirtualBoxをインストール ###

Virtualboxのサイトからインストーラをダウンロードしてインストールする。  
<https://www.virtualbox.org>

### Vagrantをインストール ###

Vagrantのサイトからインストーラをダウンロードしてインストールする。  
<http://www.vagrantup.com>

### Vagrantを起動 ###

ルートディレクトリに移動して下記コマンドを実行する。

    cd vagrant-codeigniter
    vagrant up

### hostsの編集 ###

hostsファイルにvagrant環境のIPとサイト名を記載する。

    # Macの場合
    echo "33.33.33.99 vagrant-codeigniter.local" | sudo tee -a /etc/hosts

### Codeigniterのトップページにアクセスする ###

下記URLにアクセスするとCodeIgniterのトップページが表示される。

    http://vagrant-codeigniter.local

データベースの使い方
------------------

### MySQL ###

データベースはMySQLがインストール済みです。

ホスト: `localhost`  
ユーザー名: `root`  
パスワード: `なし`

### phpMyAdmin ###

phpMyAdminがインストール済みです。
下記のURLからアクセスできます。  
<http://vagrant-codeigniter.local/phpmyadmin/>
