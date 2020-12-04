<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
#Route::get('/layout', 'HomeController@menu');

Route::get('/', function () 
{
    return view('welcome');
});

Auth::routes();
/*
|--------------------------------------------------------------------------
| Parent Modules Routes
|--------------------------------------------------------------------------
*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/packs', 'HomeController@packs');
Route::get('/administration', 'HomeController@administration');
Route::get('/reports', 'HomeController@reports');
Route::get('/configuration', 'HomeController@configuration');
Route::get('/sales', 'HomeController@sales');
Route::get('/contacts', 'HomeController@contacts');

Route::get('/update', 'HomeController@updateTax');


/*
|--------------------------------------------------------------------------
| Configuration User Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:10']], function () 
{
	Route::get('/configuration/user', 'ConfigurationUsersController@index')->name('configuration.user.index'); 
	Route::get('/configuration/user/create', 'ConfigurationUsersController@create')->name('configuration.user.create'); 
	Route::post('/configuration/user/store', 'ConfigurationUsersController@store')->name('configuration.user.store'); 
	Route::get('/configuration/user/edit', 'ConfigurationUsersController@edit')->name('configuration.user.edit'); 
	Route::get('/configuration/user/edit/{id}', 'ConfigurationUsersController@show')->name('configuration.user.show'); 
	Route::put('/configuration/user/edit/{id}/update', 'ConfigurationUsersController@update')->name('configuration.user.update'); 
	Route::get('/configuration/user/search/user', 'ConfigurationUsersController@getData')->name('user.configuration.search.user'); 
	Route::get('/configuration/user/getentdep', 'ConfigurationUsersController@getEntDep')->name('configuration.user.entdep'); 
	Route::get('/configuration/user/search/module', 'ConfigurationUsersController@getMod')->name('user.configuration.search.module');
	Route::post('/configuration/user/validate','ConfigurationUsersController@validation')->name('configuration.user.validation');
	Route::get('/configuration/user/{id}/suspend','ConfigurationUsersController@suspend')->name('configuration.user.suspend');
	Route::get('/configuration/user/{id}/reentry','ConfigurationUsersController@reentry')->name('configuration.user.reentry');
	Route::get('/configuration/user/{id}/delete','ConfigurationUsersController@delete')->name('configuration.user.delete');
	Route::post('/configuration/user/module/permission','ConfigurationUsersController@modulePermission')->name('configuration.user.module.permission');
	Route::post('/configuration/user/module/permission/update','ConfigurationUsersController@modulePermissionUpdate')->name('configuration.user.module.permission.update');
	Route::post('/configuration/user/module/permission/update-simple','ConfigurationUsersController@modulePermissionUpdateSimple')->name('configuration.user.module.permission.update.simple');
});

/*
|--------------------------------------------------------------------------
| Configuration Module Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:7']], function () 
{
	Route::get('/configuration/module', 'ConfigurationModulesController@index')->name('configuration.module.index'); 
	Route::get('/configuration/module/create', 'ConfigurationModulesController@create')->name('configuration.module.create'); 
	Route::post('/configuration/module/store', 'ConfigurationModulesController@store')->name('configuration.module.store'); 
	Route::get('/configuration/module/edit', 'ConfigurationModulesController@edit')->name('configuration.module.edit'); 
	Route::get('/configuration/module/edit/{id}', 'ConfigurationModulesController@show')->name('configuration.module.show'); 
	Route::put('/configuration/module/edit/{id}/update', 'ConfigurationModulesController@update')->name('configuration.module.update'); 
	Route::get('/configuration/module/getchild', 'ConfigurationModulesController@getChild')->name('configuration.module.getchild'); 
	Route::get('/configuration/module/{id}/delete','ConfigurationModulesController@delete')->name('configuration.module.delete');
});
/*
|--------------------------------------------------------------------------
| Administration Client Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:13']], function () 
{
	Route::get('/administration/client', 'AdministrationClientController@index')->name('administration.client.index'); 
	Route::get('/administration/client/create', 'AdministrationClientController@create')->name('administration.client.create'); 
	Route::post('/administration/client/store', 'AdministrationClientController@store')->name('administration.client.store'); 
	Route::get('/administration/client/edit', 'AdministrationClientController@edit')->name('administration.client.edit'); 
	Route::get('/administration/client/edit/{id}', 'AdministrationClientController@show')->name('administration.client.show'); 
	Route::put('/administration/client/edit/{id}/update', 'AdministrationClientController@update')->name('administration.client.update'); 
	Route::get('/administration/client/{id}/delete','AdministrationClientController@delete')->name('administration.client.delete');
});
/*
|--------------------------------------------------------------------------
| Configuration Cat Product Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:19']], function () 
{
	Route::get('/configuration/product', 'ConfigurationProductController@index')->name('configuration.product.index'); 
	Route::get('/configuration/product/create', 'ConfigurationProductController@create')->name('configuration.product.create'); 
	Route::post('/configuration/product/store', 'ConfigurationProductController@store')->name('configuration.product.store'); 
	Route::get('/configuration/product/edit', 'ConfigurationProductController@edit')->name('configuration.product.edit'); 
	Route::get('/configuration/product/edit/{id}', 'ConfigurationProductController@show')->name('configuration.product.show'); 
	Route::put('/configuration/product/edit/{id}/update', 'ConfigurationProductController@update')->name('configuration.product.update'); 
	Route::get('/configuration/product/{id}/delete','ConfigurationProductController@delete')->name('configuration.product.delete');
});
/*
|--------------------------------------------------------------------------
| Administration Warehouse Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:22']], function () 
{
	Route::get('/administration/warehouse', 'AdministrationWarehouseController@index')->name('administration.warehouse.index'); 
	Route::get('/administration/warehouse/create', 'AdministrationWarehouseController@create')->name('administration.warehouse.create'); 
	Route::post('/administration/warehouse/store', 'AdministrationWarehouseController@store')->name('administration.warehouse.store'); 
	Route::get('/administration/warehouse/edit', 'AdministrationWarehouseController@edit')->name('administration.warehouse.edit'); 
	Route::get('/administration/warehouse/edit/{id}', 'AdministrationWarehouseController@show')->name('administration.warehouse.show'); 
	Route::put('/administration/warehouse/edit/{id}/update', 'AdministrationWarehouseController@update')->name('administration.warehouse.update'); 
	Route::get('/administration/warehouse/{id}/delete','AdministrationWarehouseController@delete')->name('administration.warehouse.delete');
	Route::get('/administration/warehouse/get-product', 'AdministrationWarehouseController@getProduct'); 
	Route::get('/administration/warehouse/get-warehouse', 'AdministrationWarehouseController@getWarehouse'); 
	Route::get('/administration/warehouse/export', 'AdministrationWarehouseController@export')->name('administration.warehouse.export'); 
});

/*
|--------------------------------------------------------------------------
| Administration Provider Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:25']], function () 
{
	Route::get('/administration/provider', 'AdministrationProviderController@index')->name('administration.provider.index'); 
	Route::get('/administration/provider/create', 'AdministrationProviderController@create')->name('administration.provider.create'); 
	Route::post('/administration/provider/store', 'AdministrationProviderController@store')->name('administration.provider.store'); 
	Route::get('/administration/provider/edit', 'AdministrationProviderController@edit')->name('administration.provider.edit'); 
	Route::get('/administration/provider/edit/{id}', 'AdministrationProviderController@show')->name('administration.provider.show'); 
	Route::put('/administration/provider/edit/{id}/update', 'AdministrationProviderController@update')->name('administration.provider.update'); 
	Route::get('/administration/provider/{id}/delete','AdministrationProviderController@delete')->name('administration.provider.delete');
});

/*
|--------------------------------------------------------------------------
| Sales Product Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:16']], function () 
{
	Route::get('/sales/product', 'SalesProductController@index')->name('sales.product.index'); 
	Route::get('/sales/product/create', 'SalesProductController@create')->name('sales.product.create'); 
	Route::post('/sales/product/store', 'SalesProductController@store')->name('sales.product.store'); 
	Route::get('/sales/product/edit', 'SalesProductController@edit')->name('sales.product.edit'); 
	Route::get('/sales/product/edit/{id}', 'SalesProductController@show')->name('sales.product.show'); 
	Route::put('/sales/product/edit/{id}/update', 'SalesProductController@update')->name('sales.product.update'); 
	Route::get('/sales/product/{id}/delete','SalesProductController@delete')->name('sales.product.delete');
	Route::get('/sales/product/get-client', 'SalesProductController@getClients')->name('sales.product.get-clients'); 
	Route::post('/sales/product/store-client', 'SalesProductController@storeClient')->name('sales.product.store-client');
	Route::get('/sales/product/update-list','SalesProductController@updateList');
	Route::get('/sales/product/document/download/{id}','SalesProductController@downloadDocument')->name('sales.download.document');

});

/*
|--------------------------------------------------------------------------
| Sales Product Report Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['permission:4']], function()
{
	Route::get('/reports','ReportAdministrationController@index')->name('reports.index');
	Route::get('/reports/administration','ReportAdministrationController@administration')->name('reports.administration');
	Route::get('/reports/administration/sales','ReportAdministrationController@reportSales')->name('reports.administration.sales');
});




/*
|--------------------------------------------------------------------------
| Configuration Roles Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/role/search/role', 'ConfiguracionRolController@getData')->name('role.search.role');
Route::get('/configuration/role/search/module', 'ConfiguracionRolController@getMod')->name('role.search.module');  
Route::get('/configuration/role/search/roles', 'ConfiguracionRolController@getModules')->name('role.search.roles'); 
Route::get('/configuration/role/search','ConfiguracionRolController@search');
Route::delete('/configuration/role/search/{id}/inactive', 'ConfiguracionRolController@inactive')->name('role.inactive');
Route::delete('/configuration/role/search/{id}/reactive', 'ConfiguracionRolController@reactive')->name('role.reactive');
Route::post('/configuration/role/validate','ConfiguracionRolController@validation')->name('role.validation');
Route::resource('configuration/role', 'ConfiguracionRolController');

/*
|--------------------------------------------------------------------------
| Configuration Roles Routes
|--------------------------------------------------------------------------
*/

Route::get('configuration/places/search', 'ConfiguracionLugaresTrabajoController@getPlaces')->name('places.search');
Route::resource('configuration/places', 'ConfiguracionLugaresTrabajoController');

/*
|--------------------------------------------------------------------------
| Configuration Enterprise Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/enterprise/search','ConfiguracionEmpresaController@search');
Route::get('/configuration/enterprise/search/search', 'ConfiguracionEmpresaController@getData')->name('enterprise.search.search'); 
Route::delete('/configuration/enterprise/search/{id}/inactive', 'ConfiguracionEmpresaController@inactive')->name('enterprise.inactive');
Route::delete('/configuration/enterprise/search/{id}/reactive', 'ConfiguracionEmpresaController@reactive')->name('enterprise.reactive');
Route::post('/configuration/enterprise/validate','ConfiguracionEmpresaController@validation')->name('enterprise.validation');
Route::resource('configuration/enterprise', 'ConfiguracionEmpresaController');

/*
|--------------------------------------------------------------------------
| Configuration Area Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/area/search','ConfiguracionAreaController@search');
Route::get('/configuration/area/search/search', 'ConfiguracionAreaController@getData')->name('area.search.search'); 
Route::delete('/configuration/area/search/{id}/inactive', 'ConfiguracionAreaController@inactive')->name('area.inactive');
Route::delete('/configuration/area/search/{id}/reactive', 'ConfiguracionAreaController@reactive')->name('area.reactive');
Route::post('/configuration/area/validate','ConfiguracionAreaController@validation')->name('area.validation');
Route::resource('configuration/area', 'ConfiguracionAreaController');
/*
|--------------------------------------------------------------------------
| Configuration Department Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/department/search','ConfiguracionDepartamentoController@search');
Route::get('/configuration/department/search/search', 'ConfiguracionDepartamentoController@getData')->name('department.search.search'); 
Route::delete('/configuration/department/search/{id}/inactive', 'ConfiguracionDepartamentoController@inactive')->name('department.inactive');
Route::delete('/configuration/department/search/{id}/reactive', 'ConfiguracionDepartamentoController@reactive')->name('department.reactive');
Route::post('/configuration/department/validate','ConfiguracionDepartamentoController@validation')->name('department.validation');
Route::resource('configuration/department', 'ConfiguracionDepartamentoController');


/*
|--------------------------------------------------------------------------
| Configuration Employee Routes
|--------------------------------------------------------------------------
*/

Route::post('configuration/employee/account','ConfiguracionEmpleadoController@account')->name('employee.account');
Route::post('configuration/employee/curp','ConfiguracionEmpleadoController@curpValidate')->name('employee.curp');
Route::get('configuration/employee/search','ConfiguracionEmpleadoController@search')->name('employee.search');
Route::get('configuration/employee/massive','ConfiguracionEmpleadoController@massive')->name('employee.massive');
Route::post('configuration/employee/massive/upload','ConfiguracionEmpleadoController@massiveUpload')->name('employee.massive.upload');
Route::post('configuration/employee/massive/upload/continue','ConfiguracionEmpleadoController@massiveContinue')->name('employee.massive.continue');
Route::get('configuration/employee/massive/template',
	function()
	{
		return \Storage::disk('reserved')->download('/massive_employee/plantilla_empleados.xlsx');
	})->name('employee.massive.template');
Route::post('configuration/employee/massive/upload/cancel','ConfiguracionEmpleadoController@massiveCancel')->name('employee.massive.cancel');
Route::post('configuration/employee/export','ConfiguracionEmpleadoController@export')->name('employee.export');
Route::post('configuration/employee/export-movement','ConfiguracionEmpleadoController@exportMovement')->name('employee.export-movement');
Route::post('configuration/employee/export-layout','ConfiguracionEmpleadoController@exportLayout')->name('employee.export-layout');
Route::get('configuration/employee/historic/{employee}','ConfiguracionEmpleadoController@historic')->name('employee.historic');
//Route::get('configuration/employee/reactive/{id}','ConfiguracionEmpleadoController@reactive')->name('employee.reactive');
Route::resource('configuration/employee','ConfiguracionEmpleadoController')->except(['show', 'destroy']);


/*
|--------------------------------------------------------------------------
| Configuration Parameter Routes
|--------------------------------------------------------------------------
*/
Route::get('configuration/parameter','ConfiguracionParametroController@index')->name('parameter.index');
Route::post('configuration/parameter/update','ConfiguracionParametroController@update')->name('parameter.update');
/*
|--------------------------------------------------------------------------
| Administration Bill Routes
|--------------------------------------------------------------------------
*/
Route::get('administration/billing','AdministracionFacturacionController@Index')->name('bill.index');
Route::get('administration/billing/pending','AdministracionFacturacionController@pending')->name('bill.pending');
Route::get('administration/billing/pending/{bill}/edit','AdministracionFacturacionController@pendingEdit')->name('bill.pending.edit');
Route::post('administration/billing/pending/{bill}/update','AdministracionFacturacionController@pendingUpdate')->name('bill.pending.update');
Route::get('administration/billing/pending/{bill}/stamp','AdministracionFacturacionController@pendingStamp')->name('bill.pending.stamp');
Route::post('administration/billing/pending/{bill}/pac','AdministracionFacturacionController@pendingPac')->name('bill.pending.pac');
Route::get('administration/billing/stamped','AdministracionFacturacionController@stamped')->name('bill.stamped');
Route::get('administration/billing/stamped/{bill}/view','AdministracionFacturacionController@stampedView')->name('bill.stamped.view');
Route::get('administration/billing/stamped/pdf/{uuid}/download','AdministracionFacturacionController@downloadPDF')->name('stamped.download.pdf');
Route::get('administration/billing/stamped/xml/{uuid}/download','AdministracionFacturacionController@downloadXML')->name('stamped.download.xml');
Route::get('administration/billing/cancelled','AdministracionFacturacionController@cancelled')->name('bill.cancelled');
Route::post('administration/billing/{bill}/cancel','AdministracionFacturacionController@cancelBill')->name('bill.cancel');
Route::get('administration/billing/cancelled/{bill}/view','AdministracionFacturacionController@cancelledView')->name('bill.cancelled.view');
Route::get('administration/billing/cancelled/{bill}/status','AdministracionFacturacionController@cancelledStatusUpdate')->name('bill.cancelled.status');
Route::get('administration/billing/cancelled/pdf/{uuid}/download','AdministracionFacturacionController@downloadCancelledPDF')->name('cancelled.download.pdf');
Route::get('administration/billing/cancelled/xml/{uuid}/download','AdministracionFacturacionController@downloadCancelledXML')->name('cancelled.download.xml');
Route::get('administration/billing/cfdi','AdministracionFacturacionController@cfdi')->name('bill.cfdi');
Route::post('administration/billing/cfdi/related','AdministracionFacturacionController@cfdiRelated')->name('bill.cfdi.related');
Route::post('administration/billing/cfdi/related/search','AdministracionFacturacionController@cfdiRelatedSearch')->name('bill.cfdi.related.search');
Route::post('administration/billing/cfdi/save','AdministracionFacturacionController@cfdiSave')->name('bill.cfdi.save');
Route::post('administration/billing/cfdi/{bill}/save','AdministracionFacturacionController@cfdiSaveSaved')->name('bill.cfdi.save.saved');
Route::post('administration/billing/cfdi/stamp','AdministracionFacturacionController@cfdiStamp')->name('bill.cfdi.stamp');
Route::post('administration/billing/cfdi/{bill}/stamp','AdministracionFacturacionController@cfdiStampSaved')->name('bill.cfdi.stamp.saved');
Route::get('administration/billing/cfdi/pending','AdministracionFacturacionController@cfdiPending')->name('bill.cfdi.pending');
Route::get('administration/billing/cfdi/pending/{bill}/stamp','AdministracionFacturacionController@cfdiPendingStamp')->name('bill.cfdi.pending.stamp');
Route::get('administration/billing/nomina/pending','AdministracionFacturacionController@nominaPending')->name('bill.nomina.pending');
Route::get('administration/billing/nomina/export','AdministracionFacturacionController@exportNominaPending')->name('bill.nomina.export');
Route::get('administration/billing/nomina/pending/{bill}/stamp','AdministracionFacturacionController@nominaPendingStamp')->name('bill.nomina.pending.stamp');
Route::post('administration/billing/nomina/{bill}/stamp','AdministracionFacturacionController@nominaStampSaved')->name('bill.nomina.stamp.saved');
Route::post('administration/billing/nomina/{bill}/save','AdministracionFacturacionController@nominaSaveSaved')->name('bill.nomina.save.saved');
Route::post('administration/billing/nomina/{bill}/queue','AdministracionFacturacionController@nominaAddQueue')->name('bill.nomina.add.queue');
Route::post('administration/billing/nomina/queue','AdministracionFacturacionController@nominaAddQueueMassive')->name('bill.nomina.add.queue.massive');


/*
|--------------------------------------------------------------------------
| Configuration Project Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/project/search','ConfiguracionProyectoController@search')->name('project.search'); ;
Route::get('/configuration/project/export','ConfiguracionProyectoController@export')->name('project.export'); ;
Route::get('/configuration/project/search/search', 'ConfiguracionProyectoController@getData')->name('project.search.search'); 
Route::post('/configuration/project/validate','ConfiguracionProyectoController@validation')->name('project.validation');
Route::delete('/configuration/project/{id}/edit','ConfiguracionProyectoController@repair')->name('project.repair');
Route::resource('configuration/project','ConfiguracionProyectoController');

/*
|--------------------------------------------------------------------------
| Configuration Account Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/account/search','ConfiguracionCuentasController@search')->name('account.search');
Route::get('/configuration/account/search/search', 'ConfiguracionCuentasController@getData')->name('account.search.search'); 
Route::post('/configuration/account/validate','ConfiguracionCuentasController@validation')->name('account.validation');
Route::resource('configuration/account','ConfiguracionCuentasController');

/*
|--------------------------------------------------------------------------
| Configuration Responsibility Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/responsibility/search','ConfiguracionResponsabilidadesController@search')->name('responsibility.search');
Route::get('/configuration/responsibility/search/search', 'ConfiguracionResponsabilidadesController@getData')->name('responsibility.search.search'); 
Route::post('/configuration/responsibility/validate','ConfiguracionResponsabilidadesController@validation')->name('responsibility.validation');
Route::resource('configuration/responsibility','ConfiguracionResponsabilidadesController');

/*
|--------------------------------------------------------------------------
| Configuration Labels Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/labels/search','ConfiguracionEtiquetaController@search');
Route::get('/configuration/labels/search/search', 'ConfiguracionEtiquetaController@getLabels')->name('labels.search.search'); 
Route::post('/configuration/labels/validate','ConfiguracionEtiquetaController@validation')->name('labels.validation');
Route::resource('configuration/labels','ConfiguracionEtiquetaController');

/*
|--------------------------------------------------------------------------
| Configuration Status Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/status/search', 'ConfiguracionEstadoSolicitudController@getStatus')->name('status.search');
Route::resource('configuration/status','ConfiguracionEstadoSolicitudController');

/*
|--------------------------------------------------------------------------
| Configuration Provider Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/provider/search','ConfiguracionProveedorController@search');
Route::get('/configuration/provider/search/search', 'ConfiguracionProveedorController@getProviders')->name('provider.search.search');
Route::get('/configuration/provider/search/{id}/destroy','ConfiguracionProveedorController@destroy')->name('provider.destroy2');
Route::post('/configuration/provider/validate','ConfiguracionProveedorController@validation')->name('provider.validation');
Route::resource('configuration/provider','ConfiguracionProveedorController');

Route::get('/configuration/client/search','ConfiguracionClienteController@search');
Route::get('/configuration/client/search/search', 'ConfiguracionClienteController@getClients')->name('client.search.search');
Route::get('/configuration/client/search/{id}/destroy','ConfiguracionClienteController@destroy')->name('client.destroy2');
Route::post('/configuration/client/validate','ConfiguracionClienteController@validation')->name('client.validation');
Route::resource('configuration/client','ConfiguracionClienteController');

/*
|--------------------------------------------------------------------------
| Configuration Banks Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/banks/search','ConfiguracionBancosController@search')->name('banks.search');
Route::get('/configuration/banks/account','ConfiguracionBancosController@getAccount')->name('configuration.banks.account');
Route::resource('configuration/banks','ConfiguracionBancosController');

/*
|--------------------------------------------------------------------------
| Configuration Bank Account Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/bank-account/search','ConfiguracionCuentasBancariasController@search')->name('bank.acount.search');
Route::get('/configuration/bank-account/create','ConfiguracionCuentasBancariasController@create')->name('bank.acount.create');
Route::get('/configuration/bank-account/edit/{bank_account}','ConfiguracionCuentasBancariasController@edit')->name('bank.acount.edit');
Route::post('/configuration/bank-account/store','ConfiguracionCuentasBancariasController@store')->name('bank.acount.store');
Route::put('/configuration/bank-account/update/{bank_account}','ConfiguracionCuentasBancariasController@update')->name('bank.acount.update');
Route::post('/configuration/bank-account/account','ConfiguracionCuentasBancariasController@getAccount')->name('bank.acount.account');
Route::get('/configuration/bank-account','ConfiguracionCuentasBancariasController@index')->name('bank.acount');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::get('/profile/password','PerfilController@changepass')->name('profile.password');
Route::post('/profile/password','PerfilController@updatepass')->name('profile.password.update');
Route::resource('/profile', 'PerfilController');

/*
|--------------------------------------------------------------------------
| News Routes
|--------------------------------------------------------------------------
*/
Route::get('/news/search','NoticiasController@search')->name('news.search');
Route::get('/news/search/new','NoticiasController@getNews')->name('news.search.new');
Route::get('/news/history','NoticiasController@history')->name('news.history');
Route::get('/news/history/{id}','NoticiasController@history')->name('news.history.show');
Route::get('/releases','NoticiasController@releases')->name('releases');
Route::resource('/news', 'NoticiasController');

/*
|--------------------------------------------------------------------------
| Releases Routes
|--------------------------------------------------------------------------
*/
Route::get('/releases','ConfiguracionComunicadosController@releases')->name('releases');
Route::get('/releases/history','ConfiguracionComunicadosController@history')->name('releases.history');
Route::post('/configuration/releases/store','ConfiguracionComunicadosController@store')->name('releases.store');
Route::get('/configuration/releases/edit','ConfiguracionComunicadosController@search')->name('releases.search');
Route::get('/configuration/releases/edit/{id}','ConfiguracionComunicadosController@showRelease')->name('releases.edit.release');
Route::put('/configuration/releases/update/{id}','ConfiguracionComunicadosController@updateRelease')->name('releases.update.release');
Route::resource('/configuration/releases', 'ConfiguracionComunicadosController');



/*
|--------------------------------------------------------------------------
| Configuration TDC Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/credit-card/search','ConfiguracionTdcController@search')->name('credit-card.search');
Route::get('/configuration/credit-card/account','ConfiguracionTdcController@getAccount')->name('configuration.credit-card.account');
Route::post('/configuration/credit-card/upload','ConfiguracionTdcController@uploader')->name('credit-card.upload');
Route::put('/configuration/credit-card/{id}/account-status', 'ConfiguracionTdcController@accountStatus')->where('id','[0-9]+')->name('credit-card.account-status');
Route::resource('configuration/credit-card','ConfiguracionTdcController');

/*
|--------------------------------------------------------------------------
| Configuration Roles Routes
|--------------------------------------------------------------------------
*/
Route::get('/configuration/account-concentrated/search', 'ConfigurationGroupingAccountController@search')->name('account-concentrated.search');
Route::get('/configuration/account-concentrated/edit/{id}', 'ConfigurationGroupingAccountController@edit')->where('id','[0-9]+')->name('account-concentrated.edit');
Route::put('/configuration/account-concentrated/update/{id}', 'ConfigurationGroupingAccountController@update')->where('id','[0-9]+')->name('account-concentrated.update');
Route::get('/configuration/account-concentrated/delete/{id}', 'ConfigurationGroupingAccountController@delete')->where('id','[0-9]+')->name('account-concentrated.delete');
Route::get('/configuration/account-concentrated/get-accounts', 'ConfigurationGroupingAccountController@getAccounts')->name('account-concentrated.get-accounts');
Route::get('/configuration/account-concentrated/create', 'ConfigurationGroupingAccountController@create')->name('account-concentrated.create');
Route::post('/configuration/account-concentrated/store','ConfigurationGroupingAccountController@store')->name('account-concentrated.store');
Route::get('/configuration/account-concentrated','ConfigurationGroupingAccountController@index')->name('account-concentrated.index');


//
Route::get('/suggestions/view','SugerenciaController@view')->name('suggestions.view');
Route::get('/suggestions/view/export','SugerenciaController@export')->name('suggestions.export');
Route::resource('/suggestions','SugerenciaController');


//Route::get('/sendpass', 'SendMailsPantigerController@index');

/*
|--------------------------------------------------------------------------
| Tickets Routes
|--------------------------------------------------------------------------
*/

Route::get('/tickets/all','TicketsController@allTickets')->name('tickets.all');
Route::get('/tickets/all/{id}','TicketsController@allTicketsView')->where('id','[0-9]+')->name('tickets.all.view');

Route::get('/tickets/new','TicketsController@newTickets');
Route::post('/tickets/new/save','TicketsController@newTicketsSave')->name('tickets.new.save');

Route::get('/tickets/notassigned','TicketsController@notAssignedTickets')->name('tickets.notassigned');
//Route::get('/tickets/notassigned/{id}','TicketsController@assignedTicket')->where('id','[0-9]+')->name('tickets.assigned');
Route::put('/tickets/notassigned/{id}/update','TicketsController@assignedTicketUpdate')->where('id','[0-9]+')->name('tickets.assigned.update');

Route::get('/tickets/without-resolving','TicketsController@withoutResolvingTickets')->name('tickets.withoutresolving');
Route::get('/tickets/without-resolving/{id}','TicketsController@resolvingTickets')->where('id','[0-9]+')->name('tickets.resolving');
Route::put('/tickets/without-resolving/{id}/update','TicketsController@resolvingTicketsUpdate')->where('id','[0-9]+')->name('tickets.resolving.update');

Route::get('/tickets/assigned','TicketsController@assignedTicket')->where('id','[0-9]+')->name('tickets.assigned');
Route::get('/tickets/assigned/{id}','TicketsController@showAssignedTicket')->where('id','[0-9]+')->name('tickets.show.assigned');
Route::put('/tickets/assigned/{id}/solve','TicketsController@solvedAssignedTicket')->name('tickets.solve.assigned');

Route::get('/tickets/follow','TicketsController@followTicket')->where('id','[0-9]+')->name('tickets.follow');
Route::get('/tickets/follow/{id}','TicketsController@showFollowTicket')->where('id','[0-9]+')->name('tickets.show.follow');
Route::put('/tickets/follow/{id}/solve','TicketsController@updateFollowTicket')->name('tickets.solve.follow');
Route::put('/tickets/follow/reopen/{id}','TicketsController@reopenTicket')->where('id','[0-9]+')->name('tickets.reopen');
Route::post('/tickets/upload','TicketsController@uploader')->name('tickets.upload');

Route::get('/tickets/pending','TicketsController@pendingTickets');
Route::get('/tickets/erased','TicketsController@erasedTickets');
Route::get('/tickets/resolved','TicketsController@resolvedTickets');
Route::get('/tickets/discontinued','TicketsController@discontinuedTickets');
Route::resource('/tickets','TicketsController');
