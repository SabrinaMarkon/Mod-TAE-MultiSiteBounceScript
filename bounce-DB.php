MAIN SITE:

CREATE TABLE bounces_admin (
id integer unsigned not null primary key auto_increment,
userid varchar(255) not null,
email varchar(255) not null,
bounceerror longtext not null,
bouncedate datetime not null,
bouncesite varchar(255) not null
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--------------------------------------------------------------------------------------------------------------------------

ALL SITES: 

create table bouncesites (
id integer unsigned not null primary key auto_increment,
sitename varchar(255) not null,
siteurl varchar(255) not null,
siteactive varchar(4) not null default 'yes'
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

insert into bouncesites (sitename,siteurl,siteactive) values ("kangaroopaw","http://kangaroopaw.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("australia","http://australia.topsoloz2.info","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("bonza","http://bonza.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("mirlee","http://mirlee.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("oztralasia","http://oztralasia.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("victoria","http://vic.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("theoutback","http://theoutback.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("satellite","http://satellite.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("gumtree","http://gumtree.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("scenic","http://scenic.topsoloz.com","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("greenandgold","http://gag.topsoloz2.info","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("dragonflies","http://dragonflies.topsoloz2.info","yes");
insert into bouncesites (sitename,siteurl,siteactive) values ("webspinner","http://webspinner.topsoloz2.info","yes");

- replace "kangaroopaw" in bounceemail with matching sitename from bouncesites table:
insert into settings (name,setting) values ("bounceemail","kangaroopaw-bounce@topsoloz.com");
insert into settings (name,setting) values ("bounces","bouncenetwork");
insert into settings (name,setting) values ("bouncesmax","3");
insert into settings (name,setting) values ("bouncescriptenabled","yes");
insert into settings (name,setting) values ("bounceconsequence","vacation");
insert into settings (name,setting) values ("bounceconsequenceinallsites","yes");

CREATE TABLE bounces (
id integer unsigned not null primary key auto_increment,
userid varchar(255) not null,
email varchar(255) not null,
bounceerror longtext not null,
bouncedate datetime not null
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


- make sure admin files match the appearance of the TAE (ie. gumtree script vs 3aussies script versions)
- uncomment formatDate in bounce_admin.php and bounce_viewer.php if this function is NOT in a TAE's config.php
- phplockit
- update sendsolos and super network send files on all sites
- /admin/edit.php, /admin/deletethismember.php, /admin/editnow.php on all sites
- update /admin/adminnavigation on all sites
- add bounce files to all sites in network:

MASTER SITE:
bounce.php
bounce_curl.php
bounce_curl_all.php
bounce_max.php
/admin/bounce_admin.php
/admin/bounce_viewer.php
/admin/adminnavigation.php -> different for master because bounce_admin.php is included.
/admin/edit.php
/admin/editnow.php
/admin/deletethismember.php
/admin/ALL SEND FILES

PARTNER SITES:
bounce_curl.php
bounce_curl_all.php
bounce_max.php
/admin/bounce_viewer.php
/admin/adminnavigation
/admin/edit.php
/admin/editnow.php
/admin/deletethismember.php
/admin/ALL SEND FILES




<?php
if ($bouncescriptenabled == "yes")
{
?>
<input type="button" value="*Site* Member Bounces" style="font-size: 10px; width: 220px;" onclick="window.location='bounce_viewer.php'">
<?php
}
?>