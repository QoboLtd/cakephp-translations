<?php
namespace Translations\Model\Entity;

use Cake\ORM\Entity;

/**
 * Language Entity
 *
 * @property string $id
 * @property string $code
 * @property boolean $is_active
 * @property boolean $is_rtl
 * @property string $description
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \Translations\Model\Entity\Translation[] $translations
 */
class Language extends Entity
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
