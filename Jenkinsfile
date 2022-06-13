library 'jenkins-utils'

node("k8s") {
    stage("Checkout") {
        checkout scm
    }

    stage("Build") {
        sh("make build")
    }

    stage("Release") {
        sh("make release")
    }

    if (env.BRANCH_NAME.equals("main")) {
        stage("Deploy") {
            k8s_contexts = [
                "cst2",
                "staging",
                "datastores-us-central1"
            ]
            // getKubeconfig() is needed to get authentication to the k8s clusters
            getKubeconfig()
            // withRepoKey is needed in order to decrypt ecfg-encrypted secrets.
            // If you don't have secrets, you don't need this. But it wont break
            // anything to include it anyway.
            withRepoKey {
                k8s_contexts.each { cluster ->
                    template(cluster: cluster)
                    sh("kubectl --context ${cluster} apply -f ${env.WORKSPACE}/${cluster}/tmp-k8s")                 
                }
            }
        }
    }

    else if (env.BRANCH_NAME.equals("staging")) {
        stage("Deploy") {
            k8s_contexts = [
                "staging",
            ]
            // getKubeconfig() is needed to get authentication to the k8s clusters
            getKubeconfig()
            // withRepoKey is needed in order to decrypt ecfg-encrypted secrets.
            // If you don't have secrets, you don't need this. But it wont break
            // anything to include it anyway.
            withRepoKey {
                stage("Deploy to staging namespaces [canary]") {
                ["cst2", "cst3", "cst4"].each {cluster->
                    template(namespace: "staging", cluster: cluster)
                    sh("kubectl --context ${cluster} apply -f ${env.WORKSPACE}/${cluster}/tmp-k8s")
                }
            }
            stage("Deploy to staging cluster [cst666]") {
                ["staging"].each {cluster->
                    template(namespace: "default", cluster: cluster)
                    // The staging cluster mirrors the prod cluster. Above, "default" namespace is used because this is the intended namespace in prod
                    // and, thus, the "default" namespace will also be used on the staging cluster.
                    // If you are working on a repo that deploys to imapsync, email, forms etc. you would use that here instead of default
                    sh("kubectl --context ${cluster} apply -f ${env.WORKSPACE}/${cluster}/tmp-k8s")
                }
            }
        }
    }
}

                