import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditBodyPartComponent } from './edit-body-part.component';

describe('EditBodyPartComponent', () => {
  let component: EditBodyPartComponent;
  let fixture: ComponentFixture<EditBodyPartComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditBodyPartComponent]
    });
    fixture = TestBed.createComponent(EditBodyPartComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
