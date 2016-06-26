create table tbl_job_scheduling_task(
tbl_taskname varchar(60) not null primary key,
tbl_task_cron_exp varchar(120) not null,
tbl_url_to_launch varchar(500)
);