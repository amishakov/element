<?php

class EmStringField extends FieldBase
{
	/**
	 * Достать значение поля
	 */
	public function getValue()
	{
		return strval(strip_tags($this->fieldValue ?? ''));
	}

	/**
	 * Сохранить значение
	 */
	public function saveValue()
	{
		if(empty($this->fieldValue))
			return null;

		return $this->fieldValue;
	}
}
