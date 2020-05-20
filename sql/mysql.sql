# phpMyAdmin SQL Dump
# version 2.5.6
# http://www.phpmyadmin.net
#
# Host: localhost
# Generation Time: Mar 14, 2004 at 11:42 PM
# Server version: 4.0.13
# PHP Version: 4.3.2
# 
# Database : `xoops_beta`
# 

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_games`
#

CREATE TABLE chess_games (
    game_id                      INT(10) UNSIGNED      NOT NULL AUTO_INCREMENT,
    white_uid                    MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
    black_uid                    MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
    create_date                  DATETIME              NOT NULL,
    start_date                   DATETIME              NOT NULL,
    last_date                    DATETIME              NOT NULL,
    fen_piece_placement          VARCHAR(71)           NOT NULL DEFAULT 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR',
    fen_active_color             ENUM ('w','b')        NOT NULL DEFAULT 'w',
    fen_castling_availability    VARCHAR(4)            NOT NULL DEFAULT 'KQkq',
    fen_en_passant_target_square CHAR(2)               NOT NULL DEFAULT '-',
    fen_halfmove_clock           SMALLINT(5) UNSIGNED  NOT NULL DEFAULT '0',
    fen_fullmove_number          SMALLINT(5) UNSIGNED  NOT NULL DEFAULT '1',
    pgn_fen                      VARCHAR(100)          NOT NULL DEFAULT '',
    pgn_result                   VARCHAR(7)            NOT NULL DEFAULT '*',
    pgn_movetext                 TEXT                  NOT NULL,
    offer_draw                   ENUM ('','w','b')     NOT NULL DEFAULT '',
    suspended                    TEXT                  NOT NULL,
    white_confirm                ENUM ('0','1')        NOT NULL DEFAULT '1',
    black_confirm                ENUM ('0','1')        NOT NULL DEFAULT '1',
    PRIMARY KEY (game_id)
)
    ENGINE = MyISAM;

# --------------------------------------------------------

#
# Table structure for table `xoops_chess_challenges`
#

CREATE TABLE chess_challenges (
    challenge_id        INT(10) UNSIGNED                          NOT NULL AUTO_INCREMENT,
    game_type           ENUM ('open','user')                      NOT NULL DEFAULT 'open',
    fen                 VARCHAR(100)                              NOT NULL DEFAULT '',
    color_option        ENUM ('player2','random','white','black') NOT NULL DEFAULT 'player2',
    notify_move_player1 ENUM ('0','1')                            NOT NULL DEFAULT '0',
    player1_uid         MEDIUMINT(8) UNSIGNED                     NOT NULL DEFAULT '0',
    player2_uid         MEDIUMINT(8) UNSIGNED                     NOT NULL DEFAULT '0',
    create_date         DATETIME                                  NOT NULL ,
    PRIMARY KEY (challenge_id)
)
    ENGINE = MyISAM;
