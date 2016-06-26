create table tbl_login ( tbl_user int primary key not null, 
                         tbl_Fecha_acceso date, 
						 tbl_Fecha_salida date, 
						 tbl_Status char(1), 
						 tbl_Session_id int not null
						 );