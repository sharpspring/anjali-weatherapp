.PHONY: all build release

repo=anjali-weatherapp
shorthash=`git rev-parse --short HEAD`
base=us.gcr.io/sharpspring-us/$(repo)
branch=$${BRANCH_NAME:-`git rev-parse --abbrev-ref HEAD`}
image=$(base):$(shorthash)



# template is target which can be used to test Jinja templating locally.
# It requires that you have the ansible repo cloned at ~/dev/ansible.
# This target is not used by Jenkins!
template=ANSIBLE_HASH_BEHAVIOUR=merge ANSIBLE_JINJA2_EXTENSIONS=jinja2.ext.do ANSIBLE_ACTION_PLUGINS=~/dev/ansible/plugins/actions ansible-playbook -e "cluster=${CLUSTER} basedir=${CURDIR}/staging" -e "diff_id=`git rev-parse --short HEAD`" -i /dev/null /Volumes/dev/ansible/playbooks/template.yaml

all: build release

build:
	docker build -t $(image) .
	docker tag $(image) $(base):$(branch)

release:
	docker push $(image)
	docker push $(base):$(branch)

# Use this to test Jinja templating locally. This is not used by Jenkins!
template:
	$(template)

# Use this to test Jinja templating locally. This is not used by Jenkins!
template-without-secrets:
	$(template) --tags=no_secrets
