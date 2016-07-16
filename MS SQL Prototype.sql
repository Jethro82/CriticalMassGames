--creation of database, tables, and indexes in order to ensure all foreign key's exist when  tables are created.
use master 

drop database CMGames if exists

create database CMGames
use CmGames
--use "jpeters-frasen" - to be used 
create table tblCarrier
   (CarrierNo int primary key identity,
   CarrierName varchar(30) not null,
   CarrierSuffix varchar(40) not null)
   
create table tblCatList
     (CatNo int primary key identity,
     CatName varchar(25) not null)
     
create table tblRankPermissions
	(PrmNo int primary key identity,
	 RankName varchar(15) not null)



Create table tblUsers
	  (Useno int primary key identity,
	  Name  varchar(60) not null,
	  UseName  varchar(20) not null,
	  PassHash char(40) not null, -- password hashes are strings of 40 hex characters.
	  SundayFlags int null,
	  MondayFlags int null,
	  TuesdayFlags int null,
	  WednesdayFlags int null,
	  ThursdayFlags int null,
	  FridayFlags int null,
	  SaturdayFlags int null, -- not actually integers: each is a 24-bit set of flags representing general availability by hour. 
	  Email varchar(120) not null,
	  CellNo char(10) null,
	  CellCarrier int null, -- allow user not to list cell phone provider, even though it's a foreign key.
	  NoteCMass bit not null,
	  constraint fk_Cellcarrier
		foreign key (cellcarrier)
		references tblCarrier(CarrierNo))
	  --there is no need to look up all users of a given carrier so we omit an index for the foreign key
	  create index idxUserNames
	    on tblUsers(UseName) -- Lookup user name upon account creation/signup
	    
	  create index idxEmailaddress
	       on tblUsers(Email) -- check for existing emails upon sign up.
	       
	  create index idxCellNo
		on tblUsers(Cellno) --same as above.


 Create table tblGroups
    (GrpNo int primary key identity,
    Name varchar(50) not null,
    Category int not null,
    Game varchar(50) null,
    Closed bit not null,
    Description varchar(500) null,
    constraint fk_GroupGameCategory
        foreign key (Category)
        references tblCatlist(CatNo))
 Create index idxGroupsbyCat
    on tblGroups(Category) -- Allow quick sub searches to only certain category

Create table tblEvents
    (EvNo int primary key identity,
      EvName varchar(75) not null,
      Category int not null,
      Game varchar(50) not null,
      Description varchar(500),
      MinAttendance int not null,
      MaxAttendance int not null,
      StDate datetime not null,
      EndTime varchar(50) null,
      Sponsor int null, -- allow event NOT to be sponsored - eg. null - despite being FK.
      Official bit null,
      Closed bit null,
      constraint fk_EventCategory 
         foreign key (Category)
         references tblCatlist(CatNo),
	constraint fk_Sponser
		foreign key (Sponsor)
		references tblGroups(GrpNo))
 create index idxSponsors
      on tblEvents(Sponsor) -- Allow quick look ups of all events sponsored by a given group.
      
 create index idxEventsbyCat
    on tblEvents(Category) --Allow sub searches limited by category to run faster.
    
         

          
Create table tblEventsAttendance
    (UserNo int not null,
    EventNo int not null,
    primary key(UserNo, EventNo),
    constraint fk_AttendingUser
        foreign key (UserNo)
        references tblUsers(useno),        
     constraint fk_EventAttended
        foreign key (EventNo)
        references tblEvents(EvNo))
create index idxUsersAttending
    on tblEventsAttendance(EventNo) -- allow quick Search for list of users attending a given event
create index idxUserEventList
     on tblEventsAttendance(USerNo) -- allow quick searches for all events a given user attends
	    
	    
	     
Create table tblGroupMembers
     (GrpNo int not null,
     UsNo int not null,
     Permiss int not null,
     primary key (GrpNo, UsNo),	
     constraint fk_Group
        foreign key (GrpNo)
        references tblGroups(GrpNo),
     constraint fk_Users
		foreign key (UsNo)
		references tblUSers(Useno),
	constraint fk_Rank
		foreign key(Permiss)
		references tblRankPermissions(PrmNo))
		
	create index idxMembers
	    on tblGroupMembers(GrpNo) --- allow quick searches for all users in group
	    
	create index idxGroupList
	    on tblGroupmembers(UsNo) -- allow quick for all groups a user is a member of.
	    -- it is unnecsesary to create a table of rank permissions a search, there is no business need.
	    
	
	   
--filling of existing hard coded arrays in to tables
insert into tblCarrier(CarrierName, CarrierSuffix) values
	       ('Rogers Wireless', '@pcs.rogers.com'),
	       ('Fido','@fido.ca'),
	       ('Telus','@msg.telus.com'),
	       ('Bell Mobility', '@txt.bell.ca'),
	       ('Kudo Mobile','@msg.koodumobile.com'),
	       ('MTS','@text.mtsmobility.com'),
	       ('President`s Choice', '@txt.bell.ca'),
	       ('Sasktel','@sms.sasktell.com'),
	       ('Solo','@txt.bell.ca'),
	       ('Virgin Mobile','@vmobila.ca')
	       
insert into tblRankPermissions(RankName) values
		('SUSPENDED'),
		('Pending'),
		('Member'),
		('Junior Officer'),
		('Snr Officer'),
		('President')

insert into tblCatList(CatName) values
	('Field Sports'),('Board/Card Games'),('Category III'),
	('Category IV'),('Category V'),('Category VI'),
	('Category VII'),('Category VIII'),('Category IX'),
	('Flash Mobs'),('Other')
	
--dumping  of old pre-SQL CMGames, user and group data into new SQL data base

insert into tblUsers(Name, UseName, PassHash, SundayFlags, MondayFlags, TuesdayFlags, WednesdayFlags, ThursdayFlags, FridayFlags, SaturdayFlags, Email, Cellno, CellCarrier, NoteCMass) values
	('Jeremy Peters-Fransen ','Jethro82','fdfee2b6e05ba33505417a2edb45ebe657541125',0xffffff,0xffe000,0xfffc00,0xfffc00,0xffc000,0xf9fc00,0xffffff,'redacted@redacted.ca ',null,null,1),
('Jeremy Petes-Fransen ','Lord_Brahm','b627b1cc390f4a517690fa0796eab4b04033ce05',0xffffff,0xffffff,0xf00000,0xffffff,0xffffff,0xffffff,0xffffff,'redacted@redacted.ca',null,null,1),
('JD Peters-Fransen ','Lord_Schillington','729be26db75f9cf9ef4328e05029fded89b930c0',0xFFFFFF,0xfff000,0xffffff,0xffffff,0xffffff,0xffffff,0xffffff,'redacted@redacted.ca',null,null,1),
('Mike Friesen ','Arch_Angel','f8366d69947066e58abbb304c3d83f9e58387200',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca','1234567890',3,1),
('Mike C ','mchopeck','5122f37099dfb24f6e268c8946f1cca1bb038dce',0xffff00,0xfc0000,0xFFFFFF,0xFFFFFF,0xfc0000,0xfc0000,0xffffff,'redacted@redacted.ca','1234567890',6,1),
('Mikey Too ','mchopeck2','809c616fcd2cf8a56a5c40e0884bfc264fe7527f',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca',null,null, 1),
('Mike C ','Mikey2','da07bfdacb277eb0fc0e19b1e5bb747cc0b512d1',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca','1234567890',6,1),
('Tim ','lfc4life_8','d504f46831ef77f07533967f299d14ecf08db03e',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca', '1234567890',6,1),
('Mike Friesen ','MikeF10','1e0e1d908ee99fa0adf28f9369cd35822607ef9c',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca','1234567890',3,1),
('Austin ','Ozyman','85b40cbfd263248f0764b21b01c9abcb0a23a9f9',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca','1234567890',6,1),
('Mike ','MFreeze10','1e0e1d908ee99fa0adf28f9369cd35822607ef9c',0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca','1234567890',3,1),
('Mallard Lalonde ','mallal','74f52a7a5bc27ea2354a9c393306cc05d044d12f',0x000008,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xFFFFFF,0xffffff,'redacted@redacted.ca',null,null,1)


	
insert into tblGroups(Name, Category, Game, Closed, Description) values 
('Tabba-Guy ',3,'Abbas Guy Abbas! ',0,'We rock, being devoted to a game similar to Work, slave, work! But entirely our own'),
('Der Angriff Mussen ',4,'21t31q ',1,'asd 
fsha 
asfd'),
('RJJMMT Ultimate, etc. ',1,'Ultimate ',0,'This is the first non trivial league of Pickup-Winnipeg/Critical Mass. Hello Raf, Jon Mike, Mike, Tim. This League is for you. 

Incidentally only games of Ultimate will have notices sent out from this league, and only after you`ve been made an officer will you be able to do this. But all Closed Games in this league can be created or joined by any member. You will see the link to these games after you join. '),
('Highlander and Commander ',2,'Magic: The Gathering ',1,'Jeremy-Matthew-Austin-Alec-Torrin`s Highlander Group. And Friend`s. Self Explanatory. send me(Jeremy) feedback at my normal email adress or facebook on how this site can be improved.'),
('Die Siedler von Catan ',2,'Settler`s of Catan ',1,'Hello fellow Settlers - for those of you who don`t know the drill, this a group dedicated to Settlers games within Winnipeg. Sign up for the site, then this group and you will recieve notices of perspective games, and be notifed again when we get 3 players or more. This is a closed group, so you will have to a senior officer approve your membership application... as we say on earth c`est la vie! '),
('di wittoch di maj ',5,'Zarash ',0,'sda 
asd 
dfas'),
('Oh I`ll take the high road ',1,'and you`ll take the low road ',0,'and I`ll arrive in scotland afore ye'),
('SLICE 2012! ',10,'J1 ',0,'We scheme to get Jeremy in control of Canada... then the WORLD')

insert into tblGroupMembers(GrpNo, UsNo, Permiss ) values
(1,1 ,6),
(1,2 ,4),
(1,5 ,5),
(2,1 ,6),
(2,2 ,4),
(3,1 ,6),
(3,8 ,5),
(4,1 ,6),
(4,10 ,5),
(5,1 ,6),
(6,1 ,6),
(6,5 ,3),
(7,1 ,6),
(8,5 ,6)


--user defined function to De-code tblGroupMembers into names and ranks for a given Group.
go
create function fnGroupMembership(@GrpNo int)
returns table
as 
return

select U.UseName, U.Name, R.RankName  from tblGroupMembers as GM
inner join tblRankPermissions as R on GM.permiss=R.PrmNo
join tblUsers as U on U.Useno=GM.Usno
where GM.GrpNo=@GrpNo

select * from fnGroupMembership(4)


go

--use of sub query and scalar query
select G.Name as "Group", C.Catname as Category, G.Game as Game, R.RankName as Rank   from tblGroups as G
inner join tblGroupMembers as M on M.GrpNo =G.GrpNo 
join tblCatList as C on C.CatNo = G.Category
join tblRankPermissions as R on R.PrmNo = M.Permiss 
where M.UsNo = (select UseNo from tblUsers where
UseName = 'mchopeck') -- there is no actual need to perform a look up with a subquery here, the user number will be kept as part of the session key on the front end.
--on the back end however, that is cleaer, but a subquery was required

select COUNT(Usename) from tblUsers 
where (Email='jerzbiz@fransen.ca')   -- similarly with the procedure this is obsolete, however a scalar query was required
--originally, however the front end was going to perform verification in the php, meaning this would have been required for user validation




go
--creation of user defined procedure to add new users, check against existing user names, email, cell(if provided)
drop procedure NewUser if exists

create procedure NewUser
  @username varchar(20), -- the purpose of this procedure is to add a user,
  @name varchar(60),  -- it allows us to check whether a username, cell phone number or email is already in use with only one call to the DB.
  @Passhash char(40) , -- and will return either the appropriate error message or success message.
  @email varchar(120),
  @Cellno char(10) = null,
  @Carrier int = null,
  @notec bit
 as 
 
 if exists (select UseName from tblUsers where UseName = @username )
 begin 
  select 'User name already exists' as "Error Code" -- select as EC done by simplify communication with php code.
  return
  end
 if exists (select Email  from tblUsers where Email = @email )
 begin
  select 'Email already in use' as "Error Code"
  return;
  end
   if (@cellno is not null) and (exists (select Cellno from tblUsers where CellNo  = @cellno))
   begin
      select 'this cell number is already in use' as "Error Code" 
       return;
  end
 insert into tblUsers (Name, UseName, PassHash, SundayFlags, MondayFlags, TuesdayFlags, WednesdayFlags, ThursdayFlags, FridayFlags, SaturdayFlags, Email, CellNo, CellCarrier, NoteCMass)
 values (@name, @username, @passhash, 0xffffff, 0xffffff, 0xffffff, 0xffffff, 0xffffff, 0xffffff, 0xffffff, @email, @Cellno, @carrier, @notec);

go
--use of new procedure to add fictional, apparently swedish, user to data base.
 execute NewUser 'fjornb_85','fjorn bjornson',  '1234567812345678123456781234567812345678', 'fjorn@bjornson.sw', null, null, 1


go -- creation of view, useful to both create notification lists for groups and events.
drop view Contactlist if exists

create view Contactlist
as select U.Useno, U.Email, U.NoteCMass, U.CellNo, C.CarrierSuffix  from tblUsers as U
left join tblCarrier as C on U.CellCarrier = C.CarrierNo -- since both groups and events need to contact all members, either by email, if available, or cell-email if not this will save time.
--additionally since it omits fields that are not null you can not insert in to it.
select C.* from contactlist as C
inner join tblGroupMembers as GM on GM.UsNo =C.Useno where GM.GrpNo =1 and GM.Permiss >2

select C.* from contactlist as C
inner join tblEventsAttendance as E on E.UserNo =C.Useno where E.EventNo = 1 and C.NoteCMass=1 -- these join select statements create a list of the contact members of a group
--and then a list of contact emails for events of those users who wish to be notified when their events attain critical mass.


create role Marketing
Grant select on  tblCatlist to Marketing
Grant select on  tblEvents to Marketing
grant select on tblEventsAttendance to Marketing
grant select on tblGroupMembers to Marketing
grant select on tblGroups to Marketing
--skip tblUsers, Carriers, and RankPermissions - these are not neccesary to know for marketing analysis/ad targetting


create role FrontEnd
grant select, update, insert, delete on tblUsers to FrontEnd
grant select, update, insert, delete on tblGroupMembers to FrontEnd
grant select, update, insert on tblGroups to FrontEnd
grant select, update, insert on tblEvents to Frontend
grant select, update, insert, delete on tblEventsAttendance to FrontEnd
grant select on tblCarrier to FrontEnd
grant select on tblRankPermissions to FrontEnd
grant select on tblCatList to FrontEnd




create login Mike with password='GrandRapids'

create user Mike 
execute sp_addrolemember 'Marketing', 'Mike'

create login FE1 with password='Chaqueur'

create user FE1
execute sp_addrolemember 'FrontEnd','FE1'


execute as user = 'Mike'
select * from tblGroups -- works as Mike

update tblUsers set SaturdayFlags = 0
where Email = 'jerzbiz@fransen.ca' -- fails as Mike
revert
execute as user ='FE1'

update tblUsers set SaturdayFlags = 0
where Email = 'jerzbiz@fransen.ca' -- succeeds as Front End 1


insert into tblCarrier(CarrierName, CarrierSuffix) values
	       ('Rogers Wireless', '@pcs.rogers.com'),
	       ('Fido','@fido.ca'),
	       ('Telus','@msg.telus.com'),
	       ('Bell Mobility', '@txt.bell.ca'),
	       ('Kudo Mobile','@msg.koodumobile.com'),
	       ('MTS','@text.mtsmobility.com'),
	       ('President`s Choice', '@txt.bell.ca'),
	       ('Sasktel','@sms.sasktell.com'),
	       ('Solo','@txt.bell.ca'),
	       ('Virgin Mobile','@vmobila.ca') -- fails as Front End 1
revert
