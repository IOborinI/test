<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%team}}`
 */
class m231226_195620_insert_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db
            ->createCommand('
                INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `role`, `created_at`, `updated_at`, `verification_token`) VALUES
                    (1, \'admin\', \'*****\', \'$2y$13$wbAsA4EyJCxTIXgYRZdRKuSa7XibnA/laf04HHONramg9YJj6afMK\', \'*****\', \'admin@admin.ru\', 10, 2, 1690456890, 1690456890, \'*****\'),
                    (2, \'user1\', \'f90xdvoL_f20B7S2G1sYMs4_NuDMeDy-\', \'$2y$13$wbAsA4EyJCxTIXgYRZdRKuSa7XibnA/laf04HHONramg9YJj6afMK\', NULL, \'user1@mail.ru\', 10, 1, 1703706726, 1703706726, \'5l__6XeGWcH9fT5QBrS926TYPsd1GVfT_1703706726\'),
                    (3, \'user2\', \'KwtqQ4RRmQKjqz7vWchuAYOn0EFqyp4K\', \'$2y$13$d1PWNFVR2dDcqLsqgHUTNe7tEBucXf9oSFOLacwfBwVUBto/xcw2i\', NULL, \'user2@mail.ru\', 10, 1, 1703706786, 1703706786, \'n3P5_JAPyeFeCJpv1L1h8ya9bbXAOvJb_1703706786\');
                    
                INSERT INTO `comment` (`id`, `title`, `description`, `user_id`) VALUES
                    (1, \'title1\', \'description1\', 1),
                    (2, \'title2\', \'description2\', 1),
                    (3, \'title3\', \'description3\', 3);
	        ')
            ->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
