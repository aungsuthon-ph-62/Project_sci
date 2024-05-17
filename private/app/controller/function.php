<?php
session_start();
class Database
{
    private function connect()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=project_sci", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้: " . $e->getMessage());
        }
    }

    public function db_read($query, $params = array())
    {
        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function db_write($query, $params = array())
    {
        $pdo = $this->connect();

        try {
            $stmt = $pdo->prepare($query);
            $result = $stmt->execute($params);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }
}


class News extends Database
{

    public function get_all_draft()
    {
        // Get all news from news table
        $query = "select d.draft_unique, d.draft_topic, d.draft_created, d.draft_edit, d.draft_status, 
        u.user_fname, u.user_lname,
        cat.category_name
        from draftnews as d
        inner join users as u on u.user_unique = d.draft_author
        inner join category as cat on cat.category_unique = d.draft_category
        order by d.draft_id DESC";
        return $this->db_read($query);
    }

    public function all_draft_by($uid)
    {
        // Get all news from news table
        $query = "select d.draft_unique, d.draft_topic, d.draft_created, d.draft_edit, d.draft_status,
         u.user_fname, u.user_lname,
         category_name
        from draftnews as d
        inner join users as u on u.user_unique = d.draft_author
        inner join category as cat on cat.category_unique = d.draft_category
        where d.draft_author = '$uid'
        order by d.draft_id DESC";
        return $this->db_read($query);
    }

    public function get_draft($id)
    {
        // Get news by id from news table 
        $query = "select d.draft_unique, d.draft_topic, d.draft_banner, d.draft_article, d.draft_author, d.draft_created,
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname, u.user_image, u.user_role
        from draftnews as d
        inner join users as u on u.user_unique = d.draft_author
        inner join category as cat on cat.category_unique = d.draft_category
        where d.draft_unique = '$id'
        limit 1";
        return $this->db_read($query);
    }

    public function get_all_public($author)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_topic, news_status, n.news_created, n.news_edit, u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        where n.news_status = 'เผยแพร่' AND n.news_author = '$author'
        order by n.news_id DESC";
        return $this->db_read($query);
    }

    public function get_public($id)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_topic, n.news_banner, n.news_article, n.news_status, n.news_view, n.news_created, n.news_edit,
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname, u.user_image, u.user_role
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on cat.category_unique = n.news_category
        where n.news_unique = '$id'
        limit 1";
        return $this->db_read($query);
    }

    public function get_all_news()
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_topic, news_status, n.news_created, n.news_edit, 
        u.user_fname, u.user_lname,
        cat.category_name
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on cat.category_unique = n.news_category
        order by n.news_id DESC";
        return $this->db_read($query);
    }

    public function get_news($id)
    {
        // Get news by id from news table 
        $query = "select n.news_unique, n.news_topic, n.news_banner, n.news_article, n.news_status, n.news_view, n.news_created, n.news_author,
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname, u.user_image, u.user_role
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on cat.category_unique = n.news_category
        where n.news_unique = '$id'
        limit 1";
        return $this->db_read($query);
    }

    public function news_category()
    {
        // Get news by id from news table 
        $query = "select *
        from category as cat
        order by cat.category_id";
        return $this->db_read($query);
    }

    public function news_count()
    {
        $query = "SELECT COUNT(news_id) AS countNews FROM news";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    public function newsCategory_count()
    {
        $query = "SELECT COUNT(category_id) AS countCategory FROM category";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    public function draft_count()
    {
        $query = "SELECT COUNT(news_id) AS countDraft FROM news WHERE news_status = 'ร่าง'";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    public function public_count()
    {
        $query = "SELECT COUNT(news_id) AS countPublic FROM news WHERE news_status = 'เผยแพร่'";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    public function home_news($status, $category)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = '$status' and cat.category_name = '$category'
        order by n.news_id desc
        limit 12";
        return $this->db_read($query);
    }

    public function most_views_news()
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = 'เผยแพร่' and n.news_view > 0
        order by n.news_view desc
        limit 10";
        return $this->db_read($query);
    }

    public function news_subject()
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = 'เผยแพร่' and cat.category_name LIKE '%ภาควิชา%'
        order by n.news_view desc
        limit 9";
        return $this->db_read($query);
    }

    public function countNewsCategory($id)
    {
        $query = "SELECT COUNT(news_id) AS countNewsCategory FROM news WHERE news_category LIKE '%" . $id . "%'";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    public function sidebar_news($status)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = '$status'
        order by n.news_id desc
        limit 5";
        return $this->db_read($query);
    }

    public function newslist_category($category)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_article, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = 'เผยแพร่' and category_name LIKE '%" . $category . "%'
        order by n.news_id desc";
        return $this->db_read($query);
    }

    public function newslist_search($search)
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_article, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_topic LIKE '%" . $search . "%' OR n.news_article LIKE '%" . $search . "%' OR n.news_created LIKE '%" . $search . "%'
        OR u.user_fname LIKE '%" . $search . "%' OR u.user_lname LIKE '%" . $search . "%'
        OR cat.category_name LIKE '%" . $search . "%'
        GROUP BY n.news_id
        ORDER BY n.news_id DESC";
        return $this->db_read($query);
    }

    public function newslist()
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_article, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where n.news_status = 'เผยแพร่' AND cat.category_name = 'ข่าวทั่วไป'
        order by n.news_id desc";
        return $this->db_read($query);
    }

    public function newsSelect_list()
    {
        // Get all news from news table
        $query = "select n.news_unique, n.news_banner, n.news_topic, n.news_status, n.news_view, n.news_created, 
        cat.category_unique, cat.category_name,
        u.user_fname, u.user_lname
        from news as n
        inner join users as u on u.user_unique = n.news_author
        inner join category as cat on n.news_category = cat.category_unique
        where news_newsletterUsed IS NULL
        order by n.news_id desc";
        return $this->db_read($query);
    }

    private function connect()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=project_sci", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้: " . $e->getMessage());
        }
    }

    public function getSelectedNews($selectedValues)
    {
        // Prepare the placeholders for the query
        $placeholders = implode(',', array_fill(0, count($selectedValues), '?'));

        // Prepare the SQL statement with placeholders
        $query = "SELECT * FROM news WHERE news_unique IN ($placeholders) ORDER BY news_id DESC";

        // Get the database connection
        $pdo = $this->connect();

        // Prepare the statement
        $stmt = $pdo->prepare($query);

        // Bind the selected values to the statement
        $stmt->execute($selectedValues);

        // Fetch the result
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the statement
        $stmt->closeCursor();

        // Return the articles
        return $articles;
    }
}

class newsletter extends Database
{
    public function get_all_newsletter()
    {
        $query = "select n.newsletter_unique, n.newsletter_topic, n.newsletter_file, n.newsletter_created, u.user_fname, u.user_lname
        from newsletter as n
        inner join users as u on u.user_unique = n.newsletter_author
        order by n.newsletter_id DESC";
        return $this->db_read($query);
    }

    public function get_newsletter($id)
    {
        $query = "select *
        from newsletter
        where newsletter_unique = '$id'
        limit 1";
        return $this->db_read($query);
    }

    public function newsletter_count()
    {
        $query = "SELECT COUNT(newsletter_id) AS countNewsletter FROM newsletter";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }
}

class User extends Database
{

    public function users_count()
    {
        $query = "SELECT COUNT(user_id) AS countUsers FROM users";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $count = $result[0];
        return $count;
    }

    // Register function to create new user
    public function signUp($postData)
    {
        $firstName = addslashes($postData['first_name']);
        $lastName = addslashes($postData['last_name']);
        $email = addslashes($postData['email']);
        $password = addslashes($postData['password']);
        $role = addslashes($postData['role']);
        date_default_timezone_set('Asia/Bangkok');
        $date = date("Y-m-d H:i:s");

        $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 10);
        $uniqid = "user_" . $rand;
        // Check if unique_id already exists
        $existingUnique_id = $this->getUserByUniqueID($uniqid);
        if ($existingUnique_id) {
            $rand = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 0, 10);
            $uniqid = "user_" . $rand;
            return $uniqid;
        }

        // Validate input data
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            return "กรุณากรอกข้อมูลให้ครบ";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert new user into database
        $query = "INSERT INTO users (user_unique, user_email, user_password, user_fname, user_lname, user_role, user_created) VALUES ('$uniqid', '$email', '$hashedPassword', '$firstName', '$lastName', '$role', '$date')";
        $result = $this->db_write($query);
        if (!$result) {
            return "เกิดข้อผิดพลาด, ไม่สารมารถเพิ่มข้อมูลได้";
        }

        return "success";
    }

    public function signIn($postData)
    {

        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            return "อีเมลล์หรือรหัสผ่านไม่ถูกต้อง";
        }

        $email = addslashes($postData['email']);
        $password = addslashes($postData['password']);

        // Validate input data
        if (empty($email) || empty($password)) {
            return "อีเมลล์หรือรหัสผ่านไม่ถูกต้อง";
        }

        // Insert new user into database
        $query = "SELECT * FROM users WHERE user_email = '$email' LIMIT 1";
        $result = $this->db_read($query);
        if (!$result) {
            return "เกิดข้อผิดพลาด";
        } else {
            $row = $result[0];
            $storedPassword = $row['user_password'];
            $approve = $row['user_approve'];

            if (password_verify($password, $storedPassword)) {
                if ($approve != null) {
                    $_SESSION['id'] = $row['user_unique'];
                    $_SESSION['role'] = $row['user_role'];
                    return "success";
                } else {
                    return "บัญชีของท่านยังไม่ได้รับการยืนยัน!";
                }
            } else {
                return "อีเมลล์หรือรหัสผ่านไม่ถูกต้อง";
            }
        }
    }

    // Get user by email function
    public function getUserByEmail($email)
    {
        // Check if email already exists in the database
        $query = "SELECT * FROM users WHERE user_email='$email'";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $user = $result[0];
        return $user;
    }

    // Get user by unique_id function
    public function getUserByUniqueID($unique_id)
    {
        // Check if unique_id already exists in the database
        $query = "SELECT * FROM users WHERE user_unique='$unique_id' LIMIT 1";
        $result = $this->db_read($query);
        if (!$result) {
            return null;
        }
        $user = $result[0];
        return $user;
    }

    public function get_all_user($id)
    {
        // Get all user
        $query = "SELECT * FROM users WHERE NOT user_unique = '$id' ORDER BY user_id DESC";
        return $this->db_read($query);
    }

    public function access($role)
    {
        $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

        switch ($role) {
            case 'แอดมิน':
                $allow[] = "แอดมิน";

                return in_array($user_role, $allow);
                break;
            case 'นักสื่อสารองค์กร':
                $allow[] = "แอดมิน";
                $allow[] = "นักสื่อสารองค์กร";

                return in_array($user_role, $allow);
                break;
            case 'ประชาสัมพันธ์':
                $allow[] = "แอดมิน";
                $allow[] = "ประชาสัมพันธ์";

                return in_array($user_role, $allow);
                break;
            case 'บรรณาธิการ':
                $allow[] = "แอดมิน";
                $allow[] = "บรรณาธิการ";

                return in_array($user_role, $allow);
                break;
            case 'สมาชิก':
                $allow[] = "แอดมิน";
                $allow[] = "นักสื่อสารองค์กร";
                $allow[] = "ประชาสัมพันธ์";
                $allow[] = "บรรณาธิการ";
                $allow[] = "สมาชิก";

                return in_array($user_role, $allow);
                break;
            default:
                break;
        }

        return false;
    }
}

class Banner extends Database
{
    public function get_all_banner()
    {
        // Get all news from news table
        $query = "SELECT * FROM banner ORDER BY banner_id DESC";
        return $this->db_read($query);
    }
}

function cleanData($data)
{
    return htmlspecialchars($data);
}

function DateThai($strDate)
{
    if ($strDate == '') {
        return null;
    }
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strHour = date("H", strtotime($strDate));
    $strMinute = date("i", strtotime($strDate));
    $strSeconds = date("s", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
}

function DateThaiOnly($strDate)
{
    if ($strDate == '') {
        return null;
    }
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
