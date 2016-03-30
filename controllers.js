webserviceApp.controller('mainController',
    ['$scope', '$http', '$uibModal', 'ngProgressFactory', 'blueprintsService',
        function ($scope, $http, $uibModal, ngProgressFactory, blueprintsService) {

            $scope.progressbar = ngProgressFactory.createInstance();
            $scope.progressbar.start();

            blueprintsService.getAll()
                .then(function (response) {
                    $scope.blueprintsInformationResult = response;
                    $scope.progressbar.complete();
                });

            $scope.displayedBlueprintsInformationResult = [].concat($scope.blueprintsInformationResult);

            $scope.compileBlueprints = function () {
                $scope.progressbar.start();
                blueprintsService.compile()
                    .then(function (response) {
                        if (response) {
                            $scope.progressbar.complete();
                        } else {
                            $scope.progressbar.stop();
                        }
                    }
                );
            };

            $scope.deployServices = function () {
                $scope.progressbar.start();
                blueprintsService.deployServices()
                    .then(function (response) {
                        if (response) {
                            $scope.progressbar.complete();
                        } else {
                            $scope.progressbar.stop();
                        }
                    }
                );
            };

            $scope.testServiceModal = function (blueprintName) {
                $uibModal
                    .open({
                        animation: true,
                        templateUrl: 'pages/testServiceModal.html',
                        controller: 'testServiceModalController',
                        resolve: {
                            blueprintName: function () {
                                return blueprintName;
                            }
                        }
                    }
                );
            };

            $scope.deleteModal = function (blueprintName) {
                var deleteModalInstance = $uibModal
                    .open({
                        animation: true,
                        templateUrl: 'pages/deleteModal.html',
                        controller: 'deleteModalController',
                        resolve: {
                            blueprintName: function () {
                                return blueprintName;
                            }
                        }
                    }
                );

                deleteModalInstance.result
                    .then(function (blueprintName) {
                        blueprintsService.delete(blueprintName)
                            .then(function (response) {
                                $scope.blueprintsInformationResult = response;
                                $scope.compileBlueprints();
                            }
                        );
                    }
                );
            };

            $scope.addModal = function () {
                var addModalInstance = $uibModal
                    .open({
                        animation: true,
                        templateUrl: 'pages/formModal.html',
                        controller: 'addModalController'
                    }
                );

                addModalInstance.result
                    .then(function () {
                        blueprintsService.insert()
                            .then(function (response) {
                                $scope.blueprintsInformationResult = response;
                                $scope.compileBlueprints();
                            }
                        );
                    }
                );
            };

            $scope.updateModal = function (blueprintName) {

                var updateModalInstance = $uibModal
                    .open({
                        animation: true,
                        templateUrl: 'pages/formModal.html',
                        controller: 'updateModalController',
                        resolve: {
                            blueprintName: function () {
                                return blueprintName;
                            }
                        }
                    }
                );


                updateModalInstance.result
                    .then(function () {
                        blueprintsService.update()
                            .then(function (response) {
                                $scope.blueprintsInformationResult = response;
                                $scope.compileBlueprints();
                            }
                        );
                    }
                );

            };
        }
    ]
);

webserviceApp.controller('testServiceModalController',
    ['$http', '$scope', '$uibModal', '$uibModalInstance', '$httpParamSerializer', '$location', 'ngProgressFactory', 'blueprintName', 'blueprintsService',
        function ($http, $scope, $uibModal, $uibModalInstance, $httpParamSerializer, $location, ngProgressFactory, blueprintName, blueprintsService) {
            $scope.blueprintName = blueprintName;
            $scope.parametersValue = {};

            $scope.$watch('parametersValue', function () {
                if (angular.equals({}, $scope.parametersValue) == false) {
                    $scope.url = $location.absUrl() + "services/get" + $scope.blueprintName + ".php?" + $httpParamSerializer($scope.parametersValue);
                } else {
                    $scope.url = $location.absUrl() + "services/get" + $scope.blueprintName + ".php";
                }

            }, true);

            blueprintsService.find(blueprintName)
                .then(function (response) {
                    $scope.parameters = response.parameters;
                    $scope.description = response.description;
                }
            );


            $scope.jsonModal = function () {
                $scope.progressbar = ngProgressFactory.createInstance();
                $scope.progressbar.start();
                /*
                 for (var i = 0; i <= 10; i++) {
                 $http.get("services/get" + $scope.blueprintName + ".php", {
                 params: $scope.parametersValue
                 }
                 )
                 .then(function (response) {
                 console.log('success');
                 console.log(response);
                 }
                 );
                 }
                 */
                blueprintsService.getTestService($scope.blueprintName, $scope.parametersValue)
                    .then(function (response) {
                        $uibModal.open({
                                animation: true,
                                templateUrl: 'pages/jsonModal.html',
                                controller: 'jsonModalController',
                                resolve: {
                                    responseData: function () {
                                        $scope.progressbar.complete();
                                        return response;
                                    }
                                }
                            }
                        );
                    }
                );

            };

            $scope.cancel = function () {
                $uibModalInstance.dismiss();
            };
        }
    ]
);

webserviceApp.controller('jsonModalController',
    ['$scope', '$uibModalInstance', 'responseData',
        function ($scope, $uibModalInstance, responseData) {
            $scope.responseData = responseData;

            $scope.ok = function () {
                $uibModalInstance.dismiss();
            };
        }
    ]
);

webserviceApp.controller('deleteModalController',
    ['$scope', '$uibModalInstance', 'blueprintName',
        function ($scope, $uibModalInstance, blueprintName) {
            $scope.blueprintName = blueprintName;

            $scope.ok = function () {
                $uibModalInstance.close($scope.blueprintName);
            };

            $scope.cancel = function () {
                $uibModalInstance.dismiss();
            };
        }
    ]
);

webserviceApp.controller('updateModalController',
    ['$scope', '$uibModalInstance', 'blueprintName', 'blueprintsService',
        function ($scope, $uibModalInstance, blueprintName, blueprintsService) {
            $scope.action = "Edit";

            blueprintsService.find(blueprintName)
                .then(function (response) {
                    $scope.blueprintName = response.blueprintName;
                    $scope.serviceName = response.serviceName;
                    $scope.serviceNumber = response.serviceNumber;
                    $scope.returnDataStartAt = parseFloat(response.returnDataStartAt);
                    $scope.parameters = response.parameters;
                    $scope.properties = response.properties;
                    $scope.description = response.description;
                }
            );


            $scope.submit = function () {
                blueprintsService.blueprintName = $scope.blueprintName;
                blueprintsService.serviceName = $scope.serviceName;
                blueprintsService.serviceNumber = $scope.serviceNumber;
                blueprintsService.returnDataStartAt = $scope.returnDataStartAt;
                blueprintsService.parameters = $scope.parameters;
                blueprintsService.properties = $scope.properties;
                blueprintsService.description = $scope.description;
                $uibModalInstance.close();
            };

            $scope.cancel = function () {
                $uibModalInstance.dismiss();
            };
        }
    ]
);

webserviceApp.controller('addModalController',
    ['$scope', '$uibModalInstance', 'blueprintsService',
        function ($scope, $uibModalInstance, blueprintsService) {

            $scope.action = "Add";

            $scope.parameters = [];
            $scope.properties = [];


            $scope.submit = function () {
                blueprintsService.blueprintName = $scope.blueprintName;
                blueprintsService.serviceName = $scope.serviceName;
                blueprintsService.serviceNumber = $scope.serviceNumber;
                blueprintsService.returnDataStartAt = $scope.returnDataStartAt;
                blueprintsService.parameters = $scope.parameters;
                blueprintsService.properties = $scope.properties;
                blueprintsService.description = $scope.description;
                $uibModalInstance.close();
            };

            $scope.cancel = function () {
                $uibModalInstance.dismiss();
            };
        }
    ]
);