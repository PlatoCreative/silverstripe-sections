<?php
class RowExtraClassesGridField extends GridField
{
    protected function newRowClasses($total, $index, $record)
    {
        $classes = parent::newRowClasses($total, $index, $record);
        if ($record->hasMethod('GridFieldRowClasses'))
        $classes = array_merge($classes, $record->GridFieldRowClasses());
        return $classes;
    }
}
