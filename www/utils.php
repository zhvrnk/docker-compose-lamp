<?php
//enum LoanQueryType
// {
//   case Overdue;
//    case Active;
//   case Returned;
// }
/**
 * Usage example on the admin side
 * ```php
 * get_loans($conn, LoanQueryType::Active);
 * ```
 * Usage example on the user side
 * ```php
 * get_loans($conn, LoanQueryType::Active, $current_user_id);
 * ```
 * Here we supply `current_user_id` to filter results by
 * 
 */
function get_loans($conn, $view = 'ACTIVE')
{
    $query = "";
    $result = "";
    switch ($view) {
        case "RETURNED":
            $result .= "<h2>Returned Loans</h2>";
            $query = "SELECT * FROM loan WHERE returned = 1";
            break;
        case "OVERDUE":
            $result .= "<h2>Overdue Loans</h2>";
            $query = "SELECT * FROM loan WHERE loan_end < CURDATE() AND returned = 0";
            break;
        default:
        case "ACTIVE":
            $result .= "<h2>Active Loans</h2>";
            $query = "SELECT * FROM loan WHERE loan_end >= CURDATE() AND returned = 0";
            break;
    }

    $query_result = $conn->query($query);
    while ($row = $query_result->fetch_assoc()) {
        $teacher_id = $row['teacher_id'];
        $device_sn = $row['device_sn'];

        if ($view == "RETURNED") {
            $result .= "
            <div class='card my-2'>
                <div class='card-body'>
                    <ul class='list-group list-group-flush'>
                        <li class='list-group-item'><strong>Teacher ID:</strong> $teacher_id</li>
                        <li class='list-group-item'><strong>Device SN:</strong> $device_sn</li>
                    </ul>
                </div>
            </div>";
            // $result .= "<div>Teacher ID: {$row['teacher_id']}, Device ID: {$row['device_id']}, Returned</div>";
        } else {
            $loan_end = $row['loan_end'];
            $id = $row['id'];

            $result .= "<div class='card my-2'>
            <div class='card-body'>
                <ul class='list-group list-group-flush'>
                    <li class='list-group-item'><strong>Teacher ID:</strong> $teacher_id</li>
                    <li class='list-group-item'><strong>Device SN:</strong> $device_sn</li>
                    <li class='list-group-item'></strong> $loan_end</li>
                </ul>
                <a class='btn btn-primary' href='returnloan.php?id={$id}'>Return</a>
            </div>
        </div>";
            // <div>Teacher ID: {$row['teacher_id']}, Device ID: {$row['device_id']}, Due: {$row['loan_end']} 
        }
    }
    return $result;
}

/**
 * Checks if the user's role (stored in the session) is present in the provided allowlist.
 *
 * This function assumes that the user's role is stored in the `$_SESSION['role']` variable.
 * It's crucial to ensure that the session has been started using `session_start()`
 * before calling this function.
 *
 * @param array $allowlist An array of allowed user roles (strings).
 * @return bool True if the user's role is in the allowlist, false otherwise.
 * Returns false if the `$_SESSION['role']` is not set.
 *
 * @example
 * ```php
 * <?php
 * session_start();
 * $_SESSION['role'] = 'editor';
 * $allowedRoles = ['admin', 'editor', 'moderator'];
 *
 * if (is_allowed_user_role($allowedRoles)) {
 * echo "User is authorized.";
 * } else {
 * echo "User is not authorized.";
 * }
 *
 * $_SESSION['role'] = 'guest';
 * if (is_allowed_user_role($allowedRoles)) {
 * echo "User is authorized.";
 * } else {
 * echo "User is not authorized.";
 * }
 * ?>
 * ```
 */
function is_allowed_user_role(array $allowlist): bool {
    // Assuming $_SESSION['role'] is set elsewhere in your PHP code
    if (isset($_SESSION['role'])) {
        return in_array($_SESSION['role'], $allowlist);
    } else {
        // Handle the case where $_SESSION['role'] is not set
        // You might want to return false, throw an error, or handle it differently
        return false; // Or throw new Exception("Session role not set");
    }
}

// 1. See assorted devices as an anonymous user;
// 2. Login or register as an anonymous user;
//     2.1 As a logged-in user I can log out;

// 3. As a teacher I can make booking requests for devices;
// 4. As a teacher I can manage my own loans;

// 5. As an admin I can decline and approve booking requests submitted by teachers;
// 6. As an admin I can turn approved device bookings into device loans.
// 7. As an admin I can close device loans when device is returned.
// 8. As an admin I can CRUD devices.
// 9. As an admin I can see a list of registered users.

// 10. As a superadmin I can remove users;
// 11. As a superadmin I can promote users to admins;
// 12. As a superadmin I can promote admins to superadmins;
// + all regular admin priviliges.