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
(1, '北海道'),
(2, '青森県'),
(3, '岩手県'),
(4, '宮城県'),
(5, '秋田県'),
(6, '山形県'),
(7, '福島県'),
(8, '茨城県'),
(9, '栃木県'),
(10, '群馬県'),
(11, '埼玉県'),
(12, '千葉県'),
(13, '東京都'),
(14, '神奈川県'),
(15, '新潟県'),
(16, '富山県'),
(17, '石川県'),
(18, '福井県'),
(19, '山梨県'),
(20, '長野県'),
(21, '岐阜県'),
(22, '静岡県'),
(23, '愛知県'),
(24, '三重県'),
(25, '滋賀県'),
(26, '京都府'),
(27, '大阪府'),
(28, '兵庫県'),
(29, '奈良県'),
(30, '和歌山県'),
(31, '鳥取県'),
(32, '島根県'),
(33, '岡山県'),
(34, '広島県'),
(35, '山口県'),
(36, '徳島県'),
(37, '香川県'),
(38, '愛媛県'),
(39, '高知県'),
(40, '福岡県'),
(41, '佐賀県'),
(42, '長崎県'),
(43, '熊本県'),
(44, '大分県'),
(45, '宮崎県'),
(46, '鹿児島県'),
(47, '沖縄県'),
(48, 'その他'),
(49, '海外');
