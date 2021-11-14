import * as types from '../constants/action-types';

const initialState = {
  approvals: [],
  approvalsPageId: "",
  approvalsCount: "",
  isFetchingApprovalWidget: false
};

const approvalReducer = function(state = initialState, action) {
  switch(action.type) {
  	case types.REQUEST_APPROVALS:
      	return { ...state, isFetchingApprovalWidget: action.loading }
    case types.GET_APPROVALS_SUCCESS:
      	return { ...state, 
      		approvals: action.approvals.results, 
      		approvalsCount: action.approvals.total, 
      		approvalsPageId: action.approvals.pageId,
      		isFetchingApprovalWidget: false 
      	}
  }

  return state;
}

export default approvalReducer;
