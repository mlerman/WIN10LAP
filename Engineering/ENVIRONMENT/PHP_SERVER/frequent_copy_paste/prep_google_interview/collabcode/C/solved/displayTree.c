typedef struct TreeNode 
{
  int element;
  struct TreeNode *left, *right;
} TreeNode;

TreeNode *displayTree(TreeNode *node)
{
  //display the full tree
  if(node==NULL)
  {
    return;
  }
  displayTree(node->left);
  printf("| %d ", node->element); 
  displayTree(node->right);
}

void main()
{
  TreeNode myTreeRoot, myTreeLeft, myTreeRight, myTreeRightChild;
  
  myTreeRoot.element=1;
  myTreeRoot.left=&myTreeLeft;
  myTreeRoot.right=&myTreeRight;
  
  myTreeLeft.element=2;
  myTreeLeft.left=NULL;
  myTreeLeft.right=NULL;
  
  myTreeRight.element=3;
  myTreeRight.left=&myTreeRightChild;
  myTreeRight.right=NULL;

  myTreeRightChild.element=4;
  myTreeRightChild.left=NULL;
  myTreeRightChild.right=NULL;

  displayTree(&myTreeRoot);
  exit(000);
}
