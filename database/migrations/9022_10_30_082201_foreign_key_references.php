<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Users
        if (Schema::hasTable("users")) {
            Schema::table("users", function (Blueprint $table) {
                if (Schema::hasColumn("users", "created_by")) {
                    $table->foreignId("created_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("users", "updated_by")) {
                    $table->foreignId("updated_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("users", "deleted_by")) {
                    $table->foreignId("deleted_by")->change()->references("id")->on("users");
                }
            });
        }

        // Entities
        if (Schema::hasTable("entities")) {
            Schema::table("entities", function (Blueprint $table) {
                if (Schema::hasColumn("entities", "created_by")) {
                    $table->foreignId("created_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("entities", "updated_by")) {
                    $table->foreignId("updated_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("entities", "deleted_by")) {
                    $table->foreignId("deleted_by")->change()->references("id")->on("users");
                }
            });
        }

        // EntityTypes
        if (Schema::hasTable("entity_types")) {
            Schema::table("entity_types", function (Blueprint $table) {
                if (Schema::hasColumn("entity_types", "created_by")) {
                    $table->foreignId("created_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("entity_types", "updated_by")) {
                    $table->foreignId("updated_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("entity_types", "deleted_by")) {
                    $table->foreignId("deleted_by")->change()->references("id")->on("users");
                }
            });
        }

        // Attributes
        if (Schema::hasTable("attributes")) {
            Schema::table("attributes", function (Blueprint $table) {
                if (Schema::hasColumn("attributes", "created_by")) {
                    $table->foreignId("created_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("attributes", "updated_by")) {
                    $table->foreignId("updated_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("attributes", "deleted_by")) {
                    $table->foreignId("deleted_by")->change()->references("id")->on("users");
                }
            });
        }

        // Requests
        if (Schema::hasTable("requests")) {
            Schema::table("requests", function (Blueprint $table) {
                if (Schema::hasColumn("requests", "entity_id")) {
                    $table->foreignId("entity_id")->change()->references("id")->on("entities");
                }
                if (Schema::hasColumn("requests", "entity_type_id")) {
                    $table->foreignId("entity_type_id")->change()->references("id")->on("entity_types");
                }
                if (Schema::hasColumn("requests", "attribute_id")) {
                    $table->foreignId("attribute_id")->change()->references("id")->on("attributes");
                }
                if (Schema::hasColumn("requests", "created_by")) {
                    $table->foreignId("created_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("requests", "updated_by")) {
                    $table->foreignId("updated_by")->change()->references("id")->on("users");
                }
                if (Schema::hasColumn("requests", "deleted_by")) {
                    $table->foreignId("deleted_by")->change()->references("id")->on("users");
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Users
        if (Schema::hasTable("users")) {
            Schema::table("users", function (Blueprint $table) {
                if (Schema::hasColumn("users", "created_by")) {
                    $table->dropForeign("users_created_by_foreign");
                }
                if (Schema::hasColumn("users", "updated_by")) {
                    $table->dropForeign("users_updated_by_foreign");
                }
                if (Schema::hasColumn("users", "deleted_by")) {
                    $table->dropForeign("users_deleted_by_foreign");
                }
            });
        }

        // Entities
        if (Schema::hasTable("entities")) {
            Schema::table("entities", function (Blueprint $table) {
                if (Schema::hasColumn("entities", "created_by")) {
                    $table->dropForeign("entities_created_by_foreign");
                }
                if (Schema::hasColumn("entities", "updated_by")) {
                    $table->dropForeign("entities_updated_by_foreign");
                }
                if (Schema::hasColumn("entities", "deleted_by")) {
                    $table->dropForeign("entities_deleted_by_foreign");
                }
            });
        }

        // EntityTypes
        if (Schema::hasTable("entity_types")) {
            Schema::table("entity_types", function (Blueprint $table) {
                if (Schema::hasColumn("entity_types", "created_by")) {
                    $table->dropForeign("entity_types_created_by_foreign");
                }
                if (Schema::hasColumn("entity_types", "updated_by")) {
                    $table->dropForeign("entity_types_updated_by_foreign");
                }
                if (Schema::hasColumn("entity_types", "deleted_by")) {
                    $table->dropForeign("entity_types_deleted_by_foreign");
                }
            });
        }

        // Attributes
        if (Schema::hasTable("attributes")) {
            Schema::table("attributes", function (Blueprint $table) {
                if (Schema::hasColumn("attributes", "created_by")) {
                    $table->dropForeign("attributes_created_by_foreign");
                }
                if (Schema::hasColumn("attributes", "updated_by")) {
                    $table->dropForeign("attributes_updated_by_foreign");
                }
                if (Schema::hasColumn("attributes", "deleted_by")) {
                    $table->dropForeign("attributes_deleted_by_foreign");
                }
            });
        }
    }
};
