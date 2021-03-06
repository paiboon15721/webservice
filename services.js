webserviceApp.service('blueprintsService',
    ['$http',
        function ($http) {
            this.blueprintName = "";
            this.serviceName = "";
            this.serviceNumber = "";
            this.returnDataStartAt = "";
            this.parameters = "";
            this.properties = "";
            this.description = "";

            this.getTestService = function(blueprintName, parameters) {
                return $http.get("services/get" + blueprintName + ".php", {
                        params: parameters
                    }
                )
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.getAll = function () {
                return $http.get("internal_services/getBlueprintsAll.php")
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.compile = function () {
                return $http.get("internal_services/compileBlueprints.php")
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.deployServices = function () {
                return $http.get("internal_services/deployServices.php")
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.find = function (blueprintName) {
                return $http.get("internal_services/getBlueprint.php", {
                        params: {
                            blueprintName: blueprintName
                        }
                    }
                )
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.delete = function (blueprintName) {
                return $http.delete("internal_services/deleteBlueprint.php", {
                        params: {
                            blueprintName: blueprintName
                        }
                    }
                )
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.insert = function () {
                return $http.get("internal_services/insertBlueprint.php", {
                        params: {
                            blueprintName: this.blueprintName,
                            serviceName: this.serviceName,
                            serviceNumber: this.serviceNumber,
                            returnDataStartAt: this.returnDataStartAt,
                            parameters: JSON.stringify(this.parameters),
                            properties: JSON.stringify(this.properties),
                            description: this.description
                        }
                    }
                )
                    .then(function (response) {
                        return response.data;
                    }
                );
            };

            this.update = function () {
                return $http.get("internal_services/updateBlueprint.php", {
                        params: {
                            blueprintName: this.blueprintName,
                            serviceName: this.serviceName,
                            serviceNumber: this.serviceNumber,
                            returnDataStartAt: this.returnDataStartAt,
                            parameters: JSON.stringify(this.parameters),
                            properties: JSON.stringify(this.properties),
                            description: this.description
                        }
                    }
                )
                    .then(function (response) {
                        return response.data;
                    }
                );
            };
        }
    ]
);
