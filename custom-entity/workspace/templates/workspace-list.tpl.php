
function workspace_list() {
  drupal_set_title(t('Workspaces'));

  $workspaces = entity_load('workspace');
  if (empty($workspaces)) {
    return t('No workspaces found.');
  }

  // Sort by title.
  uasort($workspaces, function ($a, $b) {
    return strnatcasecmp($a->title, $b->title);
  });

  // Table headers.
  $headers = array(
    t('ID'),
    t('Title'),
    t('Description'),
    t('Status'),
    t('Operations'),
  );

  // Build rows.
  $rows = array();
  foreach ($workspaces as $workspace) {
    // Get human-readable status.
    $status_options = workspace_status_options();
    $status = isset($status_options[$workspace->status]) ? $status_options[$workspace->status] : t('Unknown');

    // Build operations links.
    $links = array();
    $links['view'] = array(
      'title' => t('View'),
      'href' => 'workspace/' . $workspace->id,
    );
    if (user_access('administer workspace')) {
      $links['edit'] = array(
        'title' => t('Edit'),
        'href' => 'workspace/' . $workspace->id . '/edit',
      );
      $links['delete'] = array(
        'title' => t('Delete'),
        'href' => 'workspace/' . $workspace->id . '/delete',
      );
    }
    $operations = theme('links', array(
      'links' => $links,
      'attributes' => array('class' => array('inline')),
    ));

    // Add row.
    $rows[] = array(
      'data' => array(
        check_plain($workspace->id),
        l(check_plain($workspace->title), 'workspace/' . $workspace->id),
        check_plain($workspace->description),
        check_plain($status),
        $operations,
      ),
    );
  }

  // Return themed table.
  return theme('table', array(
    'header' => $headers,
    'rows' => $rows,
    'attributes' => array('class' => array('workspace-table')),
    'empty' => t('No workspaces found.'),
  ));
}
