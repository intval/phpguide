window.phpgAngularModule = window.phpgAngularModule or angular.module("phpg", ["ngResource"], ($httpProvider) ->

    # Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded;charset=utf-8"
    $httpProvider.defaults.headers.post["X-Requested-With"] = "XMLHttpRequest"

    # Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [(data) ->

        ###
        The workhorse; converts an object to x-www-form-urlencoded serialization.
        @param {Object} obj
        @return {String}
        ###
        param = (obj) ->
            query = ""
            name = undefined
            value = undefined
            fullSubName = undefined
            subName = undefined
            subValue = undefined
            innerObj = undefined
            i = undefined
            for name of obj
                value = obj[name]
                if value instanceof Array
                    i = 0
                    while i < value.length
                        subValue = value[i]
                        fullSubName = name + "[" + i + "]"
                        innerObj = {}
                        innerObj[fullSubName] = subValue
                        query += param(innerObj) + "&"
                        ++i
                else if value instanceof Object
                    for subName of value
                        subValue = value[subName]
                        fullSubName = name + "[" + subName + "]"
                        innerObj = {}
                        innerObj[fullSubName] = subValue
                        query += param(innerObj) + "&"
                else query += encodeURIComponent(name) + "=" + encodeURIComponent(value) + "&"  if value isnt `undefined` and value isnt null
            (if query.length then query.substr(0, query.length - 1) else query)

        (if angular.isObject(data) and String(data) isnt "[object File]" then param(data) else data)
    ]
)


window.phpgAngularModule.factory "phpgstate", ['$window', (win)->
    return win['phpgstate'];
]
