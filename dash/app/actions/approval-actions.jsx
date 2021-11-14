import * as types from '../constants/action-types';

export function getApprovalsSuccess(approvals) {
  return {
    type: types.GET_APPROVALS_SUCCESS,
    approvals
  };
}

export function requestApprovals() {
	return {
		type: types.REQUEST_APPROVALS,
		loading: true
	}
}