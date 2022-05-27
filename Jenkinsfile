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

    if (env.BRANCH_NAME.equals("master")) {
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
                k8s_contexts.each { cluster ->
                    template(cluster: cluster)
                    sh("kubectl --context ${cluster} apply -f ./tmp-k8s")
                }
            }
        }
    }
}
