CREATE TABLE user
(
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(128) NOT NULL,
    password VARCHAR(128) NOT NULL,
    salt VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    profile TEXT,
    auth_level INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE team
(
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    login_id VARCHAR(16) NOT NULL,
    password VARCHAR(128) NOT NULL,
    salt VARCHAR(128) NOT NULL,
    name VARCHAR(128) NOT NULL,
    tel  VARCHAR(128),
    email VARCHAR(128),
    prefecture_id INTEGER NOT NULL,
    address TEXT,
    strength INTEGER DEFAULT 0,
    profile TEXT
);

CREATE TABLE collect
(
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    team_id INTEGER NOT NULL,
    day DATE NOT NULL,
    time TIME,
    locate TEXT NOT NULL,
    note TEXT,
    apply_flg INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE applicant
(
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    collect_id INTEGER NOT NULL,
    team_id INTEGER NOT NULL,
    note TEXT
);


CREATE TABLE prefecture
(
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL
);


INSERT INTO `prefecture` (`id`, `name`) VALUES
(1, '$BKL3$F;(B'),
(2, '$B@D?98)(B'),
(3, '$B4d<j8)(B'),
(4, '$B5\>k8)(B'),
(5, '$B=)ED8)(B'),
(6, '$B;37A8)(B'),
(7, '$BJ!Eg8)(B'),
(8, '$B0q>k8)(B'),
(9, '$BFJLZ8)(B'),
(10, '$B72GO8)(B'),
(11, '$B:k6L8)(B'),
(12, '$B@iMU8)(B'),
(13, '$BEl5~ET(B'),
(14, '$B?@F`@n8)(B'),
(15, '$B?73c8)(B'),
(16, '$BIY;38)(B'),
(17, '$B@P@n8)(B'),
(18, '$BJ!0f8)(B'),
(19, '$B;3M|8)(B'),
(20, '$BD9Ln8)(B'),
(21, '$B4tIl8)(B'),
(22, '$B@E2,8)(B'),
(23, '$B0&CN8)(B'),
(24, '$B;0=E8)(B'),
(25, '$B<"2l8)(B'),
(26, '$B5~ETI\(B'),
(27, '$BBg:eI\(B'),
(28, '$BJ<8K8)(B'),
(29, '$BF`NI8)(B'),
(30, '$BOB2N;38)(B'),
(31, '$BD;<h8)(B'),
(32, '$BEg:,8)(B'),
(33, '$B2,;38)(B'),
(34, '$B9-Eg8)(B'),
(35, '$B;38}8)(B'),
(36, '$BFAEg8)(B'),
(37, '$B9a@n8)(B'),
(38, '$B0&I28)(B'),
(39, '$B9bCN8)(B'),
(40, '$BJ!2,8)(B'),
(41, '$B:42l8)(B'),
(42, '$BD9:j8)(B'),
(43, '$B7'K\8)(B'),
(44, '$BBgJ,8)(B'),
(45, '$B5\:j8)(B'),
(46, '$B</;yEg8)(B'),
(47, '$B2-Fl8)(B'),
(48, '$B$=$NB>(B'),
(49, '$B3$30(B');
