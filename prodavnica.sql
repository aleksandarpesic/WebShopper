drop database if exists eshopper;
create database eshopper;

use eshopper;


CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) DEFAULT NULL,
  `avg_shop` double DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `sub_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `place_cat` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `category_id` int(10) unsigned NOT NULL,
   `sub_category_id` int(10) unsigned NOT NULL,
   FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
				ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (`sub_category_id`) REFERENCES `sub_category` (`id`)
				ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `mobile` varchar(32) DEFAULT NULL,
  `online` bool DEFAULT false,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` varchar(4096) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `cost` int(10) unsigned DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `file_path` varchar(2047) DEFAULT NULL,  
  `place_category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
 
  FOREIGN KEY (`place_category_id`) REFERENCES `place_cat` (`id`)
				ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number_of_item` int(10) unsigned DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `sent` tinyint(1) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `ad` (`id`)
			ON UPDATE CASCADE ON DELETE CASCADE,				
  FOREIGN KEY (`user_id`) REFERENCES `members` (`id`)
			ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `logdata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `num_online` int default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


delimiter //
drop procedure if exists eshopper.add_admin //
create procedure add_admin(in email varchar(55), in pass varchar(100) )
begin
insert into members (email, pass) values (email, sha1(concat('wess', (reverse(pass)) )) ); 
end //
delimiter ;

delimiter //
drop procedure if exists eshopper.add_user //
create procedure add_user(in name1 varchar(16),in lname1 varchar(16),in email1 varchar(55), in pass1 varchar(100) )
begin
insert into members (name, last_name, email, pass) values (name1, lname1, email1, sha1(concat('wess', (reverse(pass1)) )) ); 
end //
delimiter ;


delimiter //
drop procedure if exists eshopper.changePass //
create procedure changePass(in email1 varchar(55), in pass1 varchar(100) )
begin
update  members set pass = sha1(concat('wess', (reverse(pass1)) )) where email = email1 ; 
end //
delimiter ;



delimiter //
drop procedure if exists eshopper.userExists //
create procedure userExists(in user varchar(55), out b int)

begin
declare select_var int default 0;
SET select_var = (select count(*) from members 
where email=user  );

set b=0;
if select_var > 0 then set b=1;
end if;

end //
delimiter ;

CALL userExists('admfin',@t);
select @t;

delimiter //
drop function if exists eshopper.userExists //
create function userExists( user varchar(55))
returns boolean
deterministic
begin
declare select_var int default 0;
SET select_var = (select count(*) from members 
where email=user  );

if select_var > 0 then return true;
end if;
return false;
end //
delimiter ;

select userExists('admin');

/* 
delimiter //
drop function if exists eshopper.getUser //
create function getUser(user varchar(55),  pass2 varchar(55))
returns boolean
deterministic
begin
declare select_var int default 5;
SET select_var = (select count(*) from members 
where email=user and pass=password(concat('wess', (reverse(pass2)) )) ); 


if (select_var > 0 ) then return true;
end if;
return false;
end //
delimiter ;
*/
/*Gore navedena funkcija getUser radi na localhost, ali na moj server uvek vraca false!? Ovako kreirana na server radi, a i ovde :) */

delimiter //
drop function if exists getUser //
create function getUser(user varchar(55),  pass2 varchar(55))
returns boolean
deterministic
begin
declare select_pass varchar(255) ;
set select_pass= (select pass from members 
where email=user ); 

if (select_pass = sha1(concat('wess', (reverse(pass2)) )) ) then return true;
end if;
return false;
end //
delimiter ;
select getUser('admin','*4B1D7BF02542322B5DC37C28A07F87269743CD40');


delimiter //
drop function if exists eshopper.getId //
create function getId(user varchar(55))
returns int
deterministic
begin
declare select_var int default 5;
return (select id from members 
where email=user) ; 

end //
delimiter ;

/*Kad unosim oglas. Normalizacija. Unos u tabelu place_cat(ciljano mesto, zna kategoriju i pod kategoriju). Ako postoje vraca indeks te kategorije  */
delimiter //
drop function if exists eshopper.place //
create function place(cat_id int(11), sub_cat_id int (11))
returns int
deterministic
begin
declare select_var int default 0;
SET select_var = (select id from place_cat 
where category_id=cat_id and sub_category_id=sub_cat_id  );

if select_var > 0 then return select_var;
end if;

insert into place_cat (category_id, sub_category_id) values (cat_id, sub_cat_id);

SET select_var = (select id from place_cat 
where category_id=cat_id and sub_category_id=sub_cat_id  );
return select_var;
end //
delimiter ;



/*Koriscenje Trigger, Cursor i While petlje. Za svaku kategoriju proizvoda racuna prosecan broj prodatih primerka iz te kategorije. Triger se poziva tek kad administrator potvrdi da je poslao.  */
delimiter //
drop trigger if exists avg_num_buy_ad //
create trigger  avg_num_buy_ad after   
update on cart
for each row
begin
declare num_ad,i,sum_prodatih int default 1;
declare v_finish bool default false;
declare tmp_id,tmp_product_id,tmp_number_of_item int(11);

declare c cursor for 
	select id,product_id,number_of_item from cart where sent = 1 ;
declare continue handler for not found
	set v_finish=true;	
    
set num_ad=(select count(id) from category );
set sum_prodatih  = (select count(id) from cart ); 

open c;  /* U cursoru za sve proizvode(redove) iz cart u konkretnoj kategoriji povecavam avg_sum za 1. Tu dobijam koliko je prodato proizvoda iz te kategorije */
daj : loop
fetch c into tmp_id, tmp_product_id, tmp_number_of_item;
	if (v_finish= true) then 
		leave daj;
    end if;
update category as ca
left join place_cat as f on 
 f.id=tmp_product_id
set avg_shop=avg_shop+tmp_number_of_item  
where ca.id=f.category_id ;  

end loop daj;
close c;

while (i <= num_ad) do  /*Ovde za sve elemente iz kategorije vrednost delim sa ukupnim brojem prodatih artikla, pa dobijam prosek za svaki prodati*/
begin
	update category set avg_shop=(avg_shop/sum_prodatih) where id=i;    
    set i= i+1;
end;
end while;

end //
delimiter ;


SET GLOBAL event_scheduler=ON;

drop event if exists num_online;
CREATE EVENT num_online
ON SCHEDULE EVERY 1 minute
DO
	update logdata set num_online=  (select count(*) from members where `online`=true ) where id=1;

delimiter //
drop function if exists eshopper.getOnline //
create function eshopper.getOnline()
returns int
deterministic
begin
	return (select num_online from logdata where id=1);
end //
delimiter ;

set @a=getOnline();
select @a;
