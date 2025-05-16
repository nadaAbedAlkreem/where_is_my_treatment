// Use DBML to define your database structure
// Docs: https://dbml.dbdiagram.io/docs


Table "users" {
  "id" BIGINT [pk, increment]
  "name" VARCHAR(255)
  "email" VARCHAR(255) [unique]
  "password" VARCHAR(255)
  "image" VARCHAR(255)
  "phone_number" VARCHAR(20)
  "date_of_birth" DATE
  "provider" varchar(255)
  "provider_id" varchar(255)
  "fcm_token" varchar(255)
  "is_online" tinyint(1) [default: 0]
  "gender" users_gender_enum
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "expired_treatments" {
  "id" BIGINT [pk, increment]
  "treatment_id" BIGINT [not null]
  "name" VARCHAR(255) [not null]
  "description" TEXT
  "price" DECIMAL(10,2)
  "expiration_date" DATE
  "amount" INT
  "archived_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "administrators" {
  "id" BIGINT [pk, increment]
  "name" VARCHAR(255)
  "email" VARCHAR(255) [unique]
  "password" VARCHAR(255)
  "image" VARCHAR(255)
  "phone_number" VARCHAR(20)
  "status" administrators_status_enum [default: 'active']
  "parent_admin_id" BIGINT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "model_has_permission" {
  "model_id" BIGINT
  "model_type" VARCHAR(255)
  "permission_id" BIGINT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]

  Indexes {
    (model_id, model_type, permission_id) [pk]
  }
}

Table "permissions" {
  "id" BIGINT [pk, increment]
  "name" VARCHAR(255) [unique, not null]
  "description" TEXT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "roles" {
  "id" BIGINT [pk, increment]
  "name" VARCHAR(255) [unique, not null]
  "description" TEXT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Table "role_has_permissions" {
  "permission_id" BIGINT [not null]
  "role_id" BIGINT [not null]

  Indexes {
    (permission_id, role_id) [pk]
  }
}

Table "model_has_roles" {
  "role_id" BIGINT [not null]
  "model_type" VARCHAR(255) [not null]
  "model_id" BIGINT [not null]

  Indexes {
    (role_id, model_id, model_type) [pk]
  }
}
Table "pharmacies" {
  "id" BIGINT [pk, increment]
  "admin_id" BIGINT
  "name" VARCHAR(255)
  "logo" VARCHAR(255)
  "license_number" VARCHAR(100)
  "phone_number" VARCHAR(20)
  "email" VARCHAR(255)
  "address" TEXT
  "status" ENUM('active', 'inactive', 'suspended') [default: 'active']
  "description" TEXT
  "website_url" VARCHAR(255)
  "verified_at" TIMESTAMP
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}


Table "pharmacy_locations" {
  "id" BIGINT [pk, increment]
  "pharmacy_id" BIGINT
  "latitude" DECIMAL(10,8)
  "longitude" DECIMAL(11,8)
  "address" TEXT
  "city" VARCHAR(50)
  "district" VARCHAR(100)
  "phone_number" VARCHAR(20)
  "is_main_branch" BOOLEAN [default: false]
  "working_hours" TEXT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}


Table "pharmacy_registration_requests" {
  "id" BIGINT [pk, increment]
  "status" join_requests_status_enum [default: 'pending']
  "name" VARCHAR(255)
  "logo" VARCHAR(255)
  "license_number" VARCHAR(100)
  "phone_number" VARCHAR(20)
  "email" VARCHAR(255)
  "address" TEXT
  "description" TEXT
  "website_url" VARCHAR(255)
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "categories" {
  "id" BIGINT [pk, increment]
  "name" VARCHAR(255)
  "image" VARCHAR(255)
  "description" Text
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "treatments" {
  "id" BIGINT [pk, increment]
  "category_id" BIGINT
  "pharmacy_id" BIGINT
  "name" VARCHAR(255)
  "description" TEXT
  "price" DECIMAL(10,2)
  "expiration_date" DATE
  "amount" Int
  "image" VARCHAR(255)
  "manufacturing_date" DATE
  "manufacturer" VARCHAR(255)
  "barcode" VARCHAR(100)
  "approval_status" treatments_approval_status_enum [default: 'pending']
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "favorites" {
  "id" BIGINT [pk, increment]
  "user_id" BIGINT
  "treatment_id" BIGINT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "ratings" {
  "id" BIGINT [pk, increment]
  "user_id" BIGINT
  "pharmacy_id" BIGINT
  "treatment_id" BIGINT
  "rating" INT
  "comment" TEXT
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}


Table "medication_availability_requests" {
  "id" BIGINT [pk, increment]
  "user_id" BIGINT
  "status" requests_status_enum [default: 'pending']  //(بإنتظار توفر الدواء - تم الإبلاغ - ملغي)
  "notification_sent" bool  //هل تم إرسال إشعار؟ (true/false)
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "updated_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
  "deleted_at" TIMESTAMP
}

Table "request_treatments" {
  "id" BIGINT [pk, increment]
  "medication_availability_requests_id" BIGINT
  "treatment_id" BIGINT
  "quantity" INT [default: 1]
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}
// الحقل | النوع | الوصف
// id | pk | رقم الإشعار
// customer_id | fk | العميل المستقبل للإشعار
// request_id | fk | الطلب المرتبط بالإشعار
// title | string | عنوان الإشعار
// body | text | نص الإشعار
// sent_at | timestamp | وقت الإرسال
// read_at | timestamp (nullable) | وقت قراءة الإشعار (اختياري)
Table "notifications" {
  "id" BIGINT [pk, increment]
  "user_id" BIGINT
  "medication_availability_requests_id" BIGINT
  "title" VARCHAR(255)
  "body" TEXT
  "type" notifications_type_enum
  "is_read" BOOLEAN [default: FALSE]
  "created_at" TIMESTAMP [default: `CURRENT_TIMESTAMP`]
}

Ref:"treatments"."id" < "expired_treatments"."treatment_id" [delete: cascade]

Ref:"administrators"."id" < "administrators"."parent_admin_id" [delete: cascade]

Ref:"permissions"."id" < "model_has_permission"."permission_id"

Ref:"permissions"."id" < "role_has_permissions"."permission_id" [delete: cascade]

Ref:"roles"."id" < "role_has_permissions"."role_id" [delete: cascade]

Ref:"roles"."id" < "model_has_roles"."role_id" [delete: cascade]

Ref:"administrators"."id" < "pharmacies"."admin_id"

Ref:"pharmacies"."id" < "pharmacy_locations"."pharmacy_id"

Ref:"categories"."id" < "treatments"."category_id"

Ref:"users"."id" < "favorites"."user_id"

Ref:"treatments"."id" < "favorites"."treatment_id"

Ref:"users"."id" < "ratings"."user_id"

Ref:"pharmacies"."id" < "ratings"."pharmacy_id"

Ref:"treatments"."id" < "ratings"."treatment_id"

Ref:"users"."id" < "medication_availability_requests"."user_id"

Ref:"medication_availability_requests"."id" < "request_treatments"."medication_availability_requests_id"
Ref:"medication_availability_requests"."id" < "notifications"."medication_availability_requests_id"

Ref:"treatments"."id" < "request_treatments"."treatment_id"

Ref:"users"."id" < "notifications"."user_id"
