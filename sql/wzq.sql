-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema wzq
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema wzq
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wzq` DEFAULT CHARACTER SET utf8 ;
USE `wzq` ;

-- -----------------------------------------------------
-- Table `wzq`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wzq`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nick_name` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '玩家昵称',
  `email` VARCHAR(55) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `password` CHAR(32) NOT NULL DEFAULT '' COMMENT 'md5(create_time+pwd)',
  `head_img` VARCHAR(150) NOT NULL DEFAULT '' COMMENT '用户头像',
  `level` TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户等级',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = '玩家数据表';


-- -----------------------------------------------------
-- Table `wzq`.`gobang`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wzq`.`gobang` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_a` INT UNSIGNED NOT NULL COMMENT '玩家 A 的 ID',
  `user_b` INT UNSIGNED NOT NULL COMMENT '用户 B 的 ID',
  `status` TINYINT(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '棋局状态，0等待匹配，1进行中，2已完成',
  `type` TINYINT(2) NOT NULL DEFAULT 0 COMMENT '棋局类型：0随机匹配用户，1邀请码加入',
  `code` CHAR(5) NOT NULL DEFAULT '' COMMENT '邀请码：当 type 为 1 时有用',
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `begin_time` TIMESTAMP NULL COMMENT '棋局开始时间：由触发器根据 status 的状态 为 1 时写入',
  `finish_time` TIMESTAMP NULL COMMENT '棋局结束时间：由触发器根据 status 的状态为 2 时写入',
  PRIMARY KEY (`id`),
  INDEX `fk_gobang_user_b_idx` (`user_b` ASC),
  INDEX `fk_gobang_user_a_idx` (`user_a` ASC),
  CONSTRAINT `fk_gobang_user_a`
    FOREIGN KEY (`user_a`)
    REFERENCES `wzq`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_gobang_user_b`
    FOREIGN KEY (`user_b`)
    REFERENCES `wzq`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
DEFAULT CHARACTER SET = utf8
COMMENT = '棋局表';


-- -----------------------------------------------------
-- Table `wzq`.`play_track`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wzq`.`play_track` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gobang_id` INT UNSIGNED NOT NULL COMMENT '棋局 ID',
  `step` TINYINT(8) UNSIGNED NOT NULL DEFAULT 1 COMMENT '走棋步骤',
  `composition` CHAR(225) NOT NULL DEFAULT '' COMMENT '棋局状态',
  `user` ENUM('a', 'b') NOT NULL DEFAULT 'a' COMMENT '哪个玩家走的棋',
  `version` TINYINT(5) UNSIGNED NOT NULL DEFAULT 0,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_play_track_gobang_idx` (`gobang_id` ASC),
  CONSTRAINT `fk_play_track_gobang`
    FOREIGN KEY (`gobang_id`)
    REFERENCES `wzq`.`gobang` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = '步骤跟踪表';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
USE `wzq`;

DELIMITER $$
USE `wzq`$$
CREATE TRIGGER `wzq`.`user_BEFORE_UPDATE` BEFORE UPDATE ON `user` FOR EACH ROW
BEGIN
	set new.update_time = current_timestamp();
END$$

USE `wzq`$$
CREATE TRIGGER `wzq`.`gobang_BEFORE_UPDATE` BEFORE UPDATE ON `gobang` FOR EACH ROW
BEGIN
	IF new.status = 1 THEN
		SET new.begin_time = current_timestamp();
	END IF;
	IF new.status = 2 THEN
		SET new.finish_time = current_timestamp();
	END IF;
END$$


DELIMITER ;
