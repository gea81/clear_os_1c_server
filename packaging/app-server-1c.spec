
Name: app-server-1c
Epoch: 1
Version: 1.0.1
Release: 1%{dist}
Summary: **server_1c_app_name**
License: GPLv3
Group: Applications/Apps
Packager: High Tech Lider
Vendor: High Tech Lider
Source: %{name}-%{version}.tar.gz
Buildarch: noarch
Requires: %{name}-core = 1:%{version}-%{release}
Requires: app-base

%description
**server_1c_app_description**

%package core
Summary: **server_1c_app_name** - API
License: LGPLv3
Group: Applications/API
Requires: app-base-core

%description core
**server_1c_app_description**

This package provides the core API and libraries.

%prep
%setup -q
%build

%install
mkdir -p -m 755 %{buildroot}/usr/clearos/apps/server_1c
cp -r * %{buildroot}/usr/clearos/apps/server_1c/
rm -f %{buildroot}/usr/clearos/apps/server_1c/README.md
install -d -m 0755 %{buildroot}/var/clearos/server_1c
install -d -m 0755 %{buildroot}/var/clearos/server_1c/backup
install -D -m 0644 packaging/srv1cv83.php %{buildroot}/var/clearos/base/daemon/srv1cv83.php
install -D -m 0644 packaging/srv1cv83.ras.php %{buildroot}/var/clearos/base/daemon/srv1cv83.ras.php
install -D -m 0644 packaging/srv1cv83.ras.service %{buildroot}/etc/systemd/system/srv1cv83.ras.service

%post
logger -p local6.notice -t installer 'app-server-1c - installing'

%post core
logger -p local6.notice -t installer 'app-server-1c-core - installing'

if [ $1 -eq 1 ]; then
    [ -x /usr/clearos/apps/server_1c/deploy/install ] && /usr/clearos/apps/server_1c/deploy/install
fi

[ -x /usr/clearos/apps/server_1c/deploy/upgrade ] && /usr/clearos/apps/server_1c/deploy/upgrade

exit 0

%preun
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-server-1c - uninstalling'
fi

%preun core
if [ $1 -eq 0 ]; then
    logger -p local6.notice -t installer 'app-server-1c-core - uninstalling'
    [ -x /usr/clearos/apps/server_1c/deploy/uninstall ] && /usr/clearos/apps/server_1c/deploy/uninstall
fi

exit 0

%files
%defattr(-,root,root)
/usr/clearos/apps/server_1c/controllers
/usr/clearos/apps/server_1c/htdocs
/usr/clearos/apps/server_1c/views

%files core
%defattr(-,root,root)
%doc README.md
%exclude /usr/clearos/apps/server_1c/packaging
%doc README.md
%exclude /usr/clearos/apps/server_1c/unify.json
%dir /usr/clearos/apps/server_1c
%dir /var/clearos/server_1c
%dir /var/clearos/server_1c/backup
/usr/clearos/apps/server_1c/deploy
/usr/clearos/apps/server_1c/language
/usr/clearos/apps/server_1c/libraries
/var/clearos/base/daemon/srv1cv83.php
/var/clearos/base/daemon/srv1cv83.ras.php
/etc/systemd/system/srv1cv83.ras.service
