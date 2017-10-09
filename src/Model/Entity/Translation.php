<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Translations\Model\Entity;

use Cake\ORM\Entity;

/**
 * Translation Entity
 *
 * @property string $id
 * @property string $language_id
 * @property string $object_foreign_key
 * @property string $object_model
 * @property string $object_field
 * @property string $translation
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Translations\Model\Entity\Language $language
 * @property \Translations\Model\Entity\Phinxlog[] $phinxlog
 */
class Translation extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
