<?php
/**
 * Conroller for table views manipulations
 */
class TviewController extends ControllerBase
{
	/**
	 * Сохранить фильтры
	 */
	public function saveFiltersAction()
	{
		$tviewId = $this->request->get('tviewId');
		$filters = $this->request->get('filters');

		if (empty($tviewId))
			return $this->jsonResult(['success' => false, 'message' => 'empty id']);

		$tview = EmViews::findFirstById($tviewId);
		$tview->filter = $filters;
		$tview->save();

		return $this->jsonResult(['success' => true]);
	}
}
